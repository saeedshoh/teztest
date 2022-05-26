<?php


namespace App\Modules\Payments\Requests;


use Illuminate\Foundation\Http\FormRequest;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationDate;
use LVR\CreditCard\CardNumber;

class AddCardRequest extends FormRequest
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
            'card_pan' => ['required', new CardNumber],
            'card_name' => ['required', 'max:255'],
            'card_exp' => ['required', new CardExpirationDate('my')],
            'card_cvv' => ['required', new CardCvc($this->get('card_pan'))]
        ];
    }

}
