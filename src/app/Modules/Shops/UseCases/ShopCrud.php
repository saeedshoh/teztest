<?php namespace App\Modules\Shops\UseCases;


use App\Modules\Integrations\Tezsum\Services\MerchantTezsum;
use App\Modules\Shops\Models\ShopMedia;
use Illuminate\Http\UploadedFile;

use Illuminate\Support\Facades\File;
use Str;
use App\Modules\Shops\Models\Shop;
use App\Modules\Users\Models\User;
use App\Modules\Common\Traits\UploadTrait;

class ShopCrud
{
    use UploadTrait;

    public function create(array $shopArray, array $userArray, ?UploadedFile $logo)
    {
        $shop = \DB::transaction(function () use ($userArray, $shopArray, $logo) {

            $shopArray['logo'] = null;
            if ($logo) {
                $shopArray['logo'] = $this->uploadLogo($logo);
            }

            /** Create Tezsum account for Merchant */
            $tezsum = new MerchantTezsum();
            $merchant = $tezsum->createMerchant([
                'name' => $shopArray['name'],
                'phone_number' => $shopArray['phone_number']
            ]);

            $shopArray['tezsum_site_id'] = $merchant['json']['site_id'];
            $shopArray['status'] = 'ACTIVE';
            $shop = Shop::create($shopArray);

            $userArray['shop_id'] = $shop->id;
            $userArray['status'] = 'ACTIVE';
            $userArray['name'] = $userArray['full_name'];
            $userArray['password'] = bcrypt($userArray['password']);
            unset($userArray['full_name']);

            $user = User::create($userArray);
            $user->syncRoles('merchant');

            return $shop;
        });

        return $shop;
    }

    public function edit($shop, ?UploadedFile $logo)
    {
        $shopArray = request()->except(['full_name', 'email', 'password']);
        $userArray = request()->only(['full_name', 'email', 'password']);
        //dd($shopArray, $userArray);
        $shopArray['logo'] = null;
        if ($logo) {
            $shopArray['logo'] = $this->uploadLogo($logo);
        }
        $shop->fill($shopArray);
        $shop->save();
        $user = User::where('shop_id', $shop->id)->first();
        if(! is_null($user)){
            $userArray['name'] = $userArray['full_name'];
            if(! is_null($userArray['password'])){
                $userArray['password'] = bcrypt($userArray['password']);
            }else{
                unset($userArray['password']);
            }

            $user->fill($userArray);
            if ($user->isDirty()){
                $user->save();
            }
        }
    }

    public function uploadFiles($files, int $shopId)
    {
        foreach ($files as $file) {
            $title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $folder = '/media/shops/files';
            $fileName = $this->uploadOne($file, $folder, 'public');

            ShopMedia::create([
                'title' => $title,
                'shop_id' => $shopId,
                'file_name' =>  $fileName
            ]);
        }

        return true;
    }

    public function deleteFile(ShopMedia $shopMedia) :void
    {
        $imagePath = public_path("media/shops/files/{$shopMedia->file_name}");
        File::delete($imagePath);
        $shopMedia->delete();
    }

    private function uploadLogo(?UploadedFile $logo)
    {
        $size = [
            'height' => 200,
            'width' => 200
        ];
        $folder = '/media/shops/logo';
        $name = Str::slug($logo->getClientOriginalName(). '_') . time();
        $this->uploadOne($logo, $folder, 'public', $name, $size);
        return $name . '.' . $logo->getClientOriginalExtension();
    }
}
