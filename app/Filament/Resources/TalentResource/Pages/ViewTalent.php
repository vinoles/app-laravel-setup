<?php

namespace App\Filament\Resources\TalentResource\Pages;

use App\Filament\Resources\TalentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTalent extends ViewRecord
{
    protected static string $resource = TalentResource::class;

    public function getTitle(): string
    {
        return __('admin.talents.talent');
    }

}
