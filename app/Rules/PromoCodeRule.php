<?php

namespace App\Rules;

use App\Http\Services\CartService;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PromoCode;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class PromoCodeRule
 * @package App\Rules
 * @author Sumit Sharma<sumit.sharma@appinventiv.com>
 */
class PromoCodeRule implements Rule
{
    /**
     * @var $message
     */
    private $message;
    /**
     * @var $couponCode
     */
    protected $couponCode;

    /**
     * Create a new rule instance.
     * @param $couponCode
     * @return void
     */
    public function __construct($couponCode)
    {
        $this->couponCode = $couponCode;
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
        $cartService = new CartService;
        $promoCode   = PromoCode::where('coupon_code', $this->couponCode)->first();
        if (!$promoCode){
            $this->message = config('constants.coupon_code_invalid');
            return false;
        }
        $carts       = Cart::where('order_uid', $value)->get();
        $price = [];
        foreach ($carts as $data) {
            $price[] = $cartService->fetchSellingPrice($data->product_id, $data->store_id, $data->size, $data->size_unit, $data->quantity);
        }

        $total_amount = array_sum($price);
        info([$promoCode->min_amount > $total_amount,$promoCode->min_amount , $total_amount]);
        if ($promoCode->min_amount > $total_amount) {
            $this->message = "Cart must have at least " . $promoCode->min_amount. " for this coupon code";
            return false;
        }

        $promoCodeUsed = Order::where(['user_id' => request()->user()->id, 'promo_code' => $this->couponCode])->where('order_status', '<>', 'init')->count();
        if ($promoCodeUsed > $promoCode->max_redemption_per_user) {
            $this->message = "Max redemption per user exceeds";
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
