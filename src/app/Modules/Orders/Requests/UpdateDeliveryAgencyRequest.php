<?php namespace App\Modules\Orders\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryAgencyRequest extends FormRequest
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
        return [
            'name' => [
                'required',
                'string'
            ],
            'description' => [
                'string',
                'nullable'
            ],
            'status' => [
                'required_with:ACTIVE,INACTIVE'
            ],
            'city_id' => [
                'required',
                'exists:cities,id',
            ],
            'delivery_price' => [
                'required',
                'between:1,99999.99'
            ],
            'phone_number' => [
                'required',
                'digits:12',
                'starts_with:992',
                'unique:delivery_agencies',
            ],
        ];
    }
}
