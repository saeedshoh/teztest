<?php namespace App\Modules\Orders\Requests;


use App\Modules\Orders\Validations\CardIdExists;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Orders\Validations\CartExistClient;

class CreateOrderCardRequest extends FormRequest
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
            'phone_number_delivery' => ['required',  new CartExistClient()],
            'card_id' => ['required', new CardIdExists()],
            'city_id' => 'required|exists:cities,id',
            'delivery_date' => 'required|date_format:Y-m-d',
            'address' => 'required|min:3|max:191',
            'email' => 'email',
        ];
    }

}
