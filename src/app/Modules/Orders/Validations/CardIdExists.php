<?php namespace App\Modules\Orders\Validations;


use App\Modules\Payments\Models\CreditCard;
use Illuminate\Contracts\Validation\Rule;

class CardIdExists implements Rule
{
    private $message = 'Credit Card not exists';

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $cardId
     * @return bool
     */
    public function passes($attribute, $cardId)
    {
        $creditCard = CreditCard::where(['card_id' => $cardId, 'client_id' => auth()->id()]);
        if ($creditCard->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return $this->message;
    }

}
