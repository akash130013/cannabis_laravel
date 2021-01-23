<?php

namespace App\Rules;

use App\Modules\Store\Models\StoreProductStock;
use Illuminate\Contracts\Validation\Rule;

class AddCartQuantityRule implements Rule
{
    private $productId, $storeId, $size, $message;
    /**
     * Create a new rule instance.
     * @param $productId,
     * @param $storeId,
     * @param $size
     * @return void
     */
    public function __construct($productId, $storeId, $size)
    {
        $this->productId = $productId;
        $this->storeId = $storeId;
        $this->size = $size;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $size = $this->size;
        $availableQuantity = StoreProductStock::with('currentstock')
            ->where(['product_id' => $this->productId, 'store_id' => $this->storeId])
            ->whereHas('currentstock', function ($query) use ($size) {
                $query->where(['quant_unit' => $size]);
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
        if ($availableQuantity->currentstock->where('quant_unit', $this->size)->first()->total_stock < $value) {
            $this->message = "This quantity Not available";
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
