<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Media extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Automatically generate UUID when creating a new media entry
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($media) {
            $media->uuid = $media->uuid ?? Str::uuid()->toString();
        });
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
