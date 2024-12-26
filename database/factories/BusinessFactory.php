<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    protected $model = Business::class;

    public function definition(): array
    {
        $youtubeLinks = [
            'https://www.youtube.com/watch?v=ImtZ5yENzgE', // Laravel from Scratch Playlist
            'https://www.youtube.com/watch?v=MFh0Fd7BsjE', // Laravel 8 Beginners Tutorial
            'https://www.youtube.com/watch?v=2G8sUnNst-4', // Eloquent Relationships
            'https://www.youtube.com/watch?v=G1rOthIU-uo', // Laravel Livewire Introduction
            'https://www.youtube.com/watch?v=Md9jw53NkqA', // REST API in Laravel
        ];

        $businessName = $this->faker->company;
        return [
            'business_type' => $this->faker->randomElement(['Business', 'Under Corporate']),
            'slug' => \Illuminate\Support\Str::slug($businessName), // Generate slug from business name
            'business_name' => $businessName,
            'tagline' => $this->faker->sentence,
            'business_address1' => $this->faker->streetAddress,
            'business_address2' => $this->faker->secondaryAddress,
            'business_city' => $this->faker->city,
            'business_state' => $this->faker->stateAbbr,
            'business_zip' => $this->faker->postcode,
            'business_contact_first_name' => $this->faker->firstName,
            'business_contact_last_name' => $this->faker->lastName,
            'business_contact_email' => $this->faker->safeEmail,
            'business_contact_email_cc' => $this->faker->safeEmail,
            'business_contact_email_bcc' => $this->faker->safeEmail,
            'business_contact_phone' => $this->faker->phoneNumber,
            'header_color' => '#FFFFFF',
            'border_color' => '#000000',
            'special_offers' => $this->faker->randomElement(['0', '1']),
            'youtube_link' => $youtubeLinks[array_rand($youtubeLinks)], // Select a random Laravel YouTube link
            'youtube_autoplay' => $this->faker->randomElement(['0', '1']),
            'user_id' => User::factory(), // Assign to a user
        ];
    }
}
