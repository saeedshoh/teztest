<?php namespace App\Modules\Shops\Requests;


use App\Modules\Shops\Models\Shop;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $shop = request()->route('shop');
        return [
            'name' => [
                'required',
                'string'
            ],
            'full_name' => [
                'bail',
                'min:2'
            ],
            'email' => [
                'min:2',
                'email',
                Rule::unique('users', 'email')->where(function ($query) use ($shop) {
                    $query->where('shop_id', '!=', $shop->id);
                })
            ],
            'description' => [
                'required'
            ],
            'address' => [
                'required',
                'min:6',
                'max:191'
            ],
            'city_id' => [
                'required',
                'exists:cities,id',
            ],
            'shop_category_id' => [
                'required',
                'exists:shop_categories,id',
            ],
            'phone_number' => [
                //'required',
                Rule::unique('shops', 'phone_number')->where(function ($query) use ($shop) {
                    if (isset($shop->id)) {
                        $query->where('id', '!=', $shop->id);
                    }
                }),
                'digits:12',
                'starts_with:992'
            ],
            'logo' => [
                'image',
                'mimes:png',
                'dimensions:min_width=200,min_height=200,max_width=3000,max_height=3000',
            ],
            'tin' => [
                'required',
                'numeric'
            ],
            'sin' => [
                'required',
                'numeric'
            ],
            'company_name' => [
                'required',
                'min:2'
            ],
            'company_type' => [
                'required'
            ],
            'company_account_number' => [
                'required',
                'numeric'
            ],
            'bank_name' => [
                'required',
                'min:2'
            ],
            'bik' => [
                'required',
                'numeric'
            ],
            'bank_account_number' => [
                'required',
                'numeric'
            ],
            'delivery_price' => [
                'required',
                'between:1,99999.99'
            ]
        ];
    }

}
