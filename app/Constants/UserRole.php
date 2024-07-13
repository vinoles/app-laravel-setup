<?php

namespace App\Constants;

use App\Constants\Concerns\AvailableAsDropdownOptions;
use App\Constants\Concerns\CanBeRandomized;

enum UserRole: string
{
    use AvailableAsDropdownOptions,
        CanBeRandomized;

    case USER = 'user';
    case TALENT = 'talent';
    case SCOUT = 'scout';
    case SPORTS_AGENT = 'sports_agent';
    case SPONSOR =  'sponsor';
    case DOGME_USER = 'dogme_user';
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';
}

