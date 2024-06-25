<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GalleryFile extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'galleries_files';

    /**
     * The attributes that are mass assignable.
     *
     * * @var array<int, string>
     */
    protected $fillable = [
        'note',
        'path',
        'gallery_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gallery_id' => 'integer',
    ];

    /**
     * Retrieve the gallery instance.
     *
     * @return BelongsTo
     */
    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * Retrieve the permalink of the attachment.
     *
     * @return string
     */
    public function permalink(): string
    {
        return url(Storage::url($this->path));
    }
}
