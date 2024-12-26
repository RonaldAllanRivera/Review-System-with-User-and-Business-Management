<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName,
            'middle_name' => $this->faker->lastName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'secondary_email' => $this->faker->optional()->safeEmail,
            'role' => $this->faker->randomElement(['user', 'admin', 'editor']),
            'password' => bcrypt('password'), // Default password
            'program_name' => $this->faker->optional()->word,
            'team_name' => $this->faker->optional()->company,
            'team_head' => $this->faker->optional()->name,
            'team_head_phone' => $this->faker->optional()->phoneNumber,
            'parent_name' => $this->faker->optional()->name,
            'child_name' => $this->faker->optional()->name,
            'grade' => $this->faker->optional()->word,
            'gender' => $this->faker->randomElement(['m', 'f']),
            'member' => $this->faker->boolean,
            'phone_home' => $this->faker->optional()->phoneNumber,
            'mobile' => $this->faker->optional()->phoneNumber,
            'address1' => $this->faker->optional()->streetAddress,
            'address2' => $this->faker->optional()->secondaryAddress,
            'city' => $this->faker->optional()->city,
            'state' => $this->faker->optional()->stateAbbr,
            'zip' => $this->faker->optional()->postcode,
            'country' => $this->faker->randomElement(['United States', 'Canada']),
            'company' => $this->faker->optional()->company,
            'status' => $this->faker->randomElement([0, 1]),
            'email_sent' => $this->faker->randomElement([0, 1]),
            'csv_sent' => $this->faker->randomElement([0, 1]),
            'remember_token' => Str::random(10),
            'email_verified_at' => now(), // Default to verified
        ];
    }

    /**
     * Indicate that the user is an admin.
     */
    public function admin(): self
    {
        return $this->state(fn() => ['role' => 'admin']);
    }

    /**
     * Indicate that the user's email is not verified.
     */
    public function unverified(): self
    {
        return $this->state(fn() => ['email_verified_at' => null]);
    }
}
