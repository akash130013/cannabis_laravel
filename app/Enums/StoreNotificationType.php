<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StoreNotificationType extends Enum
{
    const Order              = 'order';
    const NewOrder           = "New Order placed";
    const OrderStatus        = "Order status updated";
    const OrderRated         = "Order Rated";
    const DriverRated        = "Driver Rated";
    const OrderTypeCancelled = "cancelled";
    const OrderTypePending   = "pending";

}
