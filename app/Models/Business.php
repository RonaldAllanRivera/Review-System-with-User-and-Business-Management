<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Business extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'business_type',
        'slug',
        'featured_image_id',
        'business_name',
        'tagline',
        'business_address1',
        'business_address2',
        'business_city',
        'business_state',
        'business_zip',
        'business_contact_first_name',
        'business_contact_last_name',
        'business_contact_email',
        'business_contact_email_cc',
        'business_contact_email_bcc',
        'business_contact_phone',
        'header_color',
        'border_color',
        'immediate_report',
        'immediate_report_rating1',
        'immediate_report_rating2',
        'immediate_report_rating3',
        'immediate_report_rating4',
        'immediate_report_rating5',
        'special_offers',
        'weekly_report',
        'weekly_report_flat',
        'monthly_report',
        'youtube_link',
        'youtube_autoplay',
        'user_id', // For the owner relationship
    ];

    /**
     * Get the user who owns the business.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define Media Library Collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('business_images')
            ->useDisk('public') // Ensure it uses the correct disk
            ->singleFile(); // Limit to single file per business if needed
    }
    // Define the relationship to the featured media
    public function featuredImage()
    {
        return $this->belongsTo(\App\Models\Media::class, 'featured_image_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->nonQueued();
    }

}
