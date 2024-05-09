<?php

namespace App\Constants\Concerns;

use Illuminate\Support\Collection;

trait AvailableAsDropdownOptions
{
    /**
     * Retrieve the options for a select field.
     *
     * @return Collection
     */
    public static function asDropdownOptions(): Collection
    {
        return collect(static::cases())->map(static fn ($option) => [
            'label' => $option->value,
            'value' => $option->value,
        ]);
    }

    /**
     * Retrieve the options for a select field admin.
     *
     * @return Collection
     */
    public static function asAdminDropdownOptions(): Collection
    {
        return collect(static::cases())->map(static fn ($option) => [
            // $option->value => `admin.talents.{$option->value}`,
             $option->value =>$option->value,
        ]);
    }

}
