<?php namespace App\Modules\Orders\Requests;


use App\Modules\Orders\Validations\CartExistClient;
use App\Modules\Orders\Validations\ClientHasMoney;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'phone_number_delivery' => ['required',  new CartExistClient(), new ClientHasMoney()],
            'city_id' => 'required|exists:cities,id',
            'delivery_date' => 'required|date_format:Y-m-d',
            'address' => 'required|min:3|max:191',
            'email' => 'email',
        ];
    }

}
