<?php

namespace App\Rules;

use App\Models\Cart;
use App\Modules\Store\Models\StoreDeliveryAddress;
use App\Modules\Store\Models\StoreDetails;
use App\Modules\User\Models\UserDeliveryLocation;
use Illuminate\Contracts\Validation\Rule;

class StoreUserZipcodeRule implements Rule
{
    protected $orderUid, $storeName;

    /**
     * Create a new rule instance.
     * @param $orderUid
     * @return void
     */
    public function __construct($orderUid)
    {
        $this->orderUid  = $orderUid;
        $this->storeName = [];
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
        $storeId  = [];
        $zipcode = UserDeliveryLocation::find($value)->zipcode;

        $storeIds = Cart::where('order_uid', $this->orderUid)->get(['store_id'])->pluck('store_id');
        foreach ($storeIds as $data) {
            $storeDeliveryAddress = StoreDeliveryAddress::where([
                'store_id' => $data,
                'zip_code' => $zipcode
            ])->exists();
            if (!$storeDeliveryAddress) {
                $storeId[] = $data;
            }
        }
        if (count($storeId) == 0) {
            return true;
        }
        $this->storeName = StoreDetails::whereIn('store_id', $storeId)->pluck('store_name')->unique()->toArray();
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return implode(', ', $this->storeName) . " does not deliver in this location";
    }
}
