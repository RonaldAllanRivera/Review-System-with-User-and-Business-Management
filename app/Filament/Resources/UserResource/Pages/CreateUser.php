<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Customize the form data before it is saved to the database.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Check for duplicate email
        if (isset($data['email']) && User::where('email', $data['email'])->exists()) {
            throw ValidationException::withMessages([
                'email' => 'The email address is already in use.',
            ]);
        }

        // Hash the password before saving to the database
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Set a default role if none is provided
        $data['role'] = $data['role'] ?? 'user';

        // Ensure fields that cannot be null have default values
        $defaultFields = [
            'middle_name' => '',
            'last_name' => '',
            'secondary_email' => '',
            'phone_home' => '',
            'mobile' => '',
            'team_head_phone' => '',
            'address1' => '',
            'address2' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'country' => '',
            'team_name' => '',
            'program_name' => '',
            'company' => '',
            'grade' => '',
            'gender' => 'm',
            'member' => false,
        ];

        foreach ($defaultFields as $field => $default) {
            $data[$field] = $data[$field] ?? $default;
        }

        return $data;
    }

    /**
     * Hook that runs after the record has been created.
     */
    protected function afterCreate(): void
    {
        $user = $this->record;

        // Ensure $user is an instance of App\Models\User and email exists before sending the email
        if ($user instanceof User && !empty($user->email)) {
            try {
                Mail::to($user->email)->send(new WelcomeUserMail($user));

                // Send a success notification after the email is sent
                Notification::make()
                    ->title('User Created Successfully')
                    ->body("User {$user->name} has been created and a welcome email has been sent.")
                    ->success()
                    ->send();
            } catch (\Exception $e) {
                // Send an error notification if the email fails to send
                Notification::make()
                    ->title('User Created, but Email Failed')
                    ->body("User {$user->name} was created, but the welcome email could not be sent.")
                    ->danger()
                    ->send();
            }
        } else {
            // Send a notification if the user email is missing
            Notification::make()
                ->title('User Created Successfully')
                ->body("User {$user->name} has been created.")
                ->success()
                ->send();
        }
    }

    /**
     * Add additional actions to the page.
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create and Notify')
                ->action(function () {
                    $this->create();
                    Notification::make()
                        ->title('User Creation')
                        ->body('User has been created successfully.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
