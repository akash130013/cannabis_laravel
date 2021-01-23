<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class NotificationType extends Enum
{
    const Home                      = 1;
    const Store                     = 2;
    const Product                   = 3;
    const Store_Detail              = 4;
    const Product_Detail            = 5;
    const Driver_Order_Assigned     = 6;
    const Driver_Order_cancelled    = 7;
    const Order                     = 8;
}
