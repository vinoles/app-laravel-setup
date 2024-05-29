<?php

namespace App\Constants;

use App\Constants\Concerns\AvailableAsDropdownOptions;
use App\Constants\Concerns\CanBeRandomized;

enum RolePermission: string
{
    use AvailableAsDropdownOptions,
        CanBeRandomized;

    case View = 'view';
    case ViewAny = 'view_any';
    case Create = 'create';
    case Update = 'update';
    case Restore = 'restore';
    case RestoreAny = 'restore_any';
    case Replicate = 'replicate';
    case Reorder = 'reorder';
    case Delete = 'delete';
    case DeleteAny = 'delete_any';
    case ForceDelete = 'force_delete';
    case ForceDeleteAny = 'force_delete_any';
}
