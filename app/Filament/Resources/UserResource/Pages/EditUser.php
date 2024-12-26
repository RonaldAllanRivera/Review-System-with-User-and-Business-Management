<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Customize the form data before it is saved to the database.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Check for duplicate email (excluding the current record)
        if ($data['email']) {
            $existingUser = UserResource::getModel()::where('email', $data['email'])
                ->where('id', '!=', $this->record->id)
                ->first();

            if ($existingUser) {
                throw ValidationException::withMessages([
                    'email' => 'The email address is already in use by another user.',
                ]);
            }
        }

        // Hash the password if it is being updated
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // If no new password is provided, remove it from the data array
            unset($data['password']);
        }

        return $data;
    }


    /**
     * Hook that runs after the record has been saved.
     */
    protected function afterSave(): void
    {
        $user = $this->record;

        Notification::make()
            ->title('User Updated Successfully')
            ->body("The user <strong>{$user->name}</strong> has been updated successfully.")
            ->success()
            ->send();

        // Redirect to the user index page after a successful edit
        $this->redirect(UserResource::getUrl('index'));
    }


    /**
     * Add additional actions to the page.
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
