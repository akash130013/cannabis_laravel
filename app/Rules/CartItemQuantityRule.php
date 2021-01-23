<?php

namespace App\Rules;

use App\Models\Cart;
use App\Modules\Store\Models\StoreProductStock;
use Illuminate\Contracts\Validation\Rule;

class CartItemQuantityRule implements Rule
{

    private $cartUid, $size, $sizeUnit, $message;

    /**
     * Create a new rule instance.
     * @param $cartUid
     * @return void
     */
    public function __construct($cartUid, $size, $sizeUnit)
    {
        $this->cartUid = $cartUid;
        $this->size = $size;
        $this->sizeUnit = $sizeUnit;
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
                $query->where(['quant_unit' => $this->size, 'unit' => $this->sizeUnit]);
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
        if ($availableQuantity->currentstock->where('quant_unit', $this->size)->where('unit', $this->sizeUnit)->first()->total_stock < $value) {
            $this->message = "This quantity Not available";
            return false;
        }

        $allOtherCartData = Cart::where('order_uid', $cart->order_uid)->where(['size' => $this->size, 'size_unit' => $this->sizeUnit])->where('cart_uid', '<>', $this->cartUid)->first();
        if ($allOtherCartData){
            $this->message = "This variation is already available";
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
