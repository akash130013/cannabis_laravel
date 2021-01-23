<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SearchType extends Enum
{
    const product  = 1;
    const store    = 2;
    const category = 3;
}
