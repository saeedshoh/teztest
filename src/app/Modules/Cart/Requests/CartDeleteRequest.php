<?php namespace App\Modules\Cart\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CartDeleteRequest extends FormRequest
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
                'exists:products,id'
            ]
        ];
    }

}
