<?php

namespace App\Models;

use App\Constants\HandPreference;
use App\Models\Concerns\HasUuid;
use App\Observers\TalentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([TalentObserver::class])]
class Talent extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $table = 'talents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'hand_preference',
        'birthdate',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthdate' => 'date:d-m-Y',
        'hand_preference' => HandPreference::class,
    ];

    /**
     * Check if talent  is active
     *
     * @return bool
     */
    public function isRightHanded(): bool
    {
        return $this->hand_preference === HandPreference::RIGHT;
    }

    /**
     * Check if talent  is canceled.
     *
     * @return bool
     */
    public function isLeftHanded(): bool
    {
        return $this->status === HandPreference::LEFT;
    }

    /**
     * Check if talent  is canceled.
     *
     * @return bool
     */
    public function isAmbidextrousHanded(): bool
    {
        return $this->status === HandPreference::AMBIDEXTROUS;
    }

    /**
     * Relationship with the posts table.
     *
     * @return MorphMany
     */
    public function posts(): MorphMany
    {
        return $this->morphMany(Post::class, 'postable');
    }
}
