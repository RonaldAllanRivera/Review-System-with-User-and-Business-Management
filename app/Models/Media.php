<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Media extends BaseMedia implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('business_images')->useDisk('public');
    }
}
