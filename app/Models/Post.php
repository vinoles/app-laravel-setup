<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Post extends Model
{
    use HasFactory, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'is_public',
        'postable_id',
        'postable_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Determine if the post is public.
     *
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->is_public;
    }

    /**
     * Determine if the post is public.
     *
     * @return bool
     */
    public function isPrivate(): bool
    {
        return ! $this->isPublic();
    }

    // Relationships methods

    /**
     * Get the parent postable.
     */
    public function postable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relationship with the comments table.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relationship with the galleries table.
     *
     * @return MorphOne
     */
    public function gallery(): MorphOne
    {
        return $this->morphOne(Gallery::class, 'gallerable');
    }
}
