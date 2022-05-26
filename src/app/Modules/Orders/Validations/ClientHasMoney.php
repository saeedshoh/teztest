<?php namespace App\Modules\Orders\Validations;


use App\Modules\Integrations\Tezsum\Services\UserTezsum;
use Cart;
use Illuminate\Contracts\Validation\Rule;

class ClientHasMoney implements Rule
{
    private string $message = 'Недостаточно средств на балансе.';

    /**
     * Determine if the validation rule passes.
     *
     * @param $attribute
     * @param $value
     * @return bool
     * @throws \Exception
     */
    public function passes($attribute, $value): bool
    {
        $cartSession = Cart::session(auth()->id());

        $clientBalance = (new UserTezsum())->myBalance()['json'];
        $cartTotalSum = (int) ($cartSession->getTotal() * 100);

        return ! ($clientBalance['balance'] < $cartTotalSum);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }

}
