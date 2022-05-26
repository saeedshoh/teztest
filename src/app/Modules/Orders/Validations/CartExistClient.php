<?php namespace App\Modules\Orders\Validations;


use Cart;
use Illuminate\Contracts\Validation\Rule;

class CartExistClient implements Rule
{
    private $message = 'Client has not any product at the cart.';

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $value
     * @return bool
     * @throws \Exception
     */
    public function passes($attribute, $value)
    {
        Cart::session(auth()->id());
        if (Cart::isEmpty()) {
            return false;
        }

        return true;
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
