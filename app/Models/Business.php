<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_type',
        'slug',
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
        'user_id', // Add user_id to support the relationship
    ];

    /**
     * Get the user who owns the business.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
