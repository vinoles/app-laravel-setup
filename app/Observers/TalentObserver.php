<?php

namespace App\Observers;

use App\Models\Talent;
use Illuminate\Support\Str;

class TalentObserver
{
    /**
     * Triggered before creating an talent.
     *
     * @param  Talent  $talent
     * @return void
     */
    public function creating(Talent $talent): void
    {
        // dd($talent->getAttributes());

        if ($talent->missingUuid()) {
            $talent->fill([
                'uuid' => Str::uuid(),
            ]);
        }
    }

    /**
     * Handle the Talent "created" event.
     */
    public function created(Talent $talent): void
    {
        //
    }

    /**
     * Handle the Talent "updated" event.
     */
    public function updated(Talent $talent): void
    {
        //
    }

    /**
     * Handle the Talent "deleted" event.
     */
    public function deleted(Talent $talent): void
    {
        //
    }

    /**
     * Handle the Talent "restored" event.
     */
    public function restored(Talent $talent): void
    {
        //
    }

    /**
     * Handle the Talent "force deleted" event.
     */
    public function forceDeleted(Talent $talent): void
    {
        //
    }
}
