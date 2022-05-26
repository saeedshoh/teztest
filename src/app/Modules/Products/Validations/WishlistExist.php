<?php namespace App\Modules\Products\Validations;


use App\Modules\Products\Models\Wishlist;
use Illuminate\Contracts\Validation\Rule;

class WishlistExist implements Rule
{
    private $message = 'Wishlist not exists';

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $product_id
     * @return bool
     */
    public function passes($attribute, $product_id)
    {
        $wishList = Wishlist::where(['product_id' => $product_id, 'client_id' => auth()->id()]);
        if ($wishList->exists()) {
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
