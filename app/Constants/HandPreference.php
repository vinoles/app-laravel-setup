<?php

namespace App\Constants;

use App\Constants\Concerns\AvailableAsDropdownOptions;
use App\Constants\Concerns\CanBeRandomized;

enum HandPreference: string
{
    use AvailableAsDropdownOptions, CanBeRandomized;

    case LEFT = 'left';
    case RIGHT = 'right';
    case AMBIDEXTROUS = 'ambidextrous';

}
