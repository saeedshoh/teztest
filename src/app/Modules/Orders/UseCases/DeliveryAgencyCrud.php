<?php


namespace App\Modules\Orders\UseCases;


use App\Modules\Orders\Models\DeliveryAgency;
use App\Modules\Users\Models\User;

class DeliveryAgencyCrud
{
    public function create(array $agencyArray, array $userArray)
    {
        $agency = \DB::transaction(function () use ($agencyArray, $userArray) {

            $userArray['password'] = bcrypt($userArray['password']);
            $user = User::create($userArray);

            $agencyArray['user_id'] = $user->id;
            $agency = DeliveryAgency::create($agencyArray);

            $user->syncRoles('delivery');

            return $agency;
        });


        return $agency;
    }
}
