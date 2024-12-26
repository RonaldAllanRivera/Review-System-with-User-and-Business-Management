<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_new_user()
    {
        $userData = [
            'name' => 'John',
            'middle_name' => 'M.',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'admin',
            'gender' => 'm',
            'team_name' => 'Team Alpha',
            'address1' => '123 Main Street',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10001',
            'country' => 'United States',
        ];

        $response = $this->post(route('filament.admin.resources.users.store'), $userData);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role' => 'admin',
            'name' => 'John',
            'last_name' => 'Doe',
            'team_name' => 'Team Alpha',
            'city' => 'New York',
            'state' => 'NY',
            'country' => 'United States',
        ]);
    }

    /** @test */
    public function it_validates_duplicate_email_on_creation()
    {
        User::factory()->create(['email' => 'duplicate@example.com']);

        $userData = [
            'name' => 'Duplicate',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
            'role' => 'user',
        ];

        $response = $this->post(route('filament.admin.resources.users.store'), $userData);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_does_not_require_password_on_edit()
    {
        $user = User::factory()->create([
            'name' => 'Jane',
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
        ]);

        $updatedData = [
            'name' => 'Jane Updated',
            'email' => 'jane@example.com',
            'role' => 'editor',
        ];

        $response = $this->patch(route('filament.admin.resources.users.update', $user->id), $updatedData);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Updated',
            'email' => 'jane@example.com',
            'role' => 'editor',
        ]);

        $this->assertTrue(Hash::check('password123', $user->fresh()->password));
    }

    /** @test */
    public function it_requires_a_password_on_create()
    {
        $userData = [
            'name' => 'NoPassword',
            'email' => 'nopassword@example.com',
            'role' => 'user',
        ];

        $response = $this->post(route('filament.admin.resources.users.store'), $userData);

        $response->assertSessionHasErrors('password');
    }
}
