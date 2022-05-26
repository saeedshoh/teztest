<?php namespace App\Modules\Shops\Requests;


use App\Modules\Products\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopUnSubscribeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() :bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() :array
    {
        $attributes = $this->all();
        return [
            'shop_id' => [
                'required',
                'exists:shops,id',
                Rule::exists('clients_shops_subscriptions')->where(function ($query) use ($attributes)  {
                    return $query->where(['client_id' => auth()->id(), 'shop_id' => $attributes['shop_id']]);
                }),
            ]

        ];
    }
}
