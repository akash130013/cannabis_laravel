<?php

namespace App\Rules;

use App\Models\Cart;
use App\Modules\Store\Models\StoreProductStock;
use Illuminate\Contracts\Validation\Rule;

class CartItemSizeRule implements Rule
{

    private $cartUid, $message;

    /**
     * Create a new rule instance.
     * @param $cartUid
     * @return void
     */
    public function __construct($cartUid)
    {
        $this->cartUid = $cartUid;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cart = Cart::where('cart_uid', $this->cartUid)->first();
        if (!$cart) {
            $this->message = "cart_uid does not exist";
            return false;
        }
        $availableQuantity = StoreProductStock::with('currentstock')
            ->where(['product_id' => $cart->product_id, 'store_id' => $cart->store_id])
            ->whereHas('currentstock', function ($query) use ($cart) {
                $query->where(['quant_unit' => $cart->size, 'unit' => $cart->size_unit]);
            })
            ->first();
        if (!$availableQuantity) {
            $this->message = "Product unavailable";
            return false;
        }
        if (!isset($availableQuantity->currentstock->first()->total_stock)) {
            $this->message = "Product Sold";
            return false;

        }
        if ($availableQuantity->currentstock->where('quant_unit', $cart->size)->where('unit', $cart->size_unit)->first()->total_stock < $value) {
            $this->message = "This size Not available";
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
