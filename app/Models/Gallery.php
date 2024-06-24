<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Gallery extends Model
{
    use HasFactory, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'note',
        'gallerable_id',
        'gallerable_type',
    ];

    public function gallerable()
    {
        return $this->morphTo();
    }

    /**
     * Relationship with the galleries files table.
     *
     * @return MorphMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(GalleryFile::class);
    }
}
