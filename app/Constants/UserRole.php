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
    case APP_USER = 'app_user';
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';
}

