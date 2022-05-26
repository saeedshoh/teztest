<?php namespace App\Modules\Products\Requests;


use App\Modules\Products\Validations\WishlistExist;

use Illuminate\Foundation\Http\FormRequest;

class WishlistDeleteRequest extends FormRequest
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
        return [
            'product_id' => [
                'required',
                new WishlistExist()
            ],
        ];
    }

}
