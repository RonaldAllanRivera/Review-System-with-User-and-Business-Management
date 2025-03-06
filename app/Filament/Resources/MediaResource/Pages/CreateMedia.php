<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CreateMedia extends CreateRecord
{
    protected static string $resource = MediaResource::class;

    // Temporary storage for file upload data and the associated business ID.
    protected array $uploadData = [];
    protected ?int $businessId = null;

    /**
     * Remove file upload and business ID from the payload so that the placeholder
     * record is created without them.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['file_name'])) {
            $this->uploadData = (array) $data['file_name'];
            unset($data['file_name']);
        }
        if (isset($data['model_id'])) {
            $this->businessId = $data['model_id'];
            unset($data['model_id']);
        }
        return $data;
    }

    /**
     * After the placeholder record is created, update it with the file's details.
     */
    protected function afterCreate(): void
    {
        if (!empty($this->uploadData)) {
            // Get the first file from the upload array.
            $file = $this->uploadData[0];

            if (is_string($file)) {
                // File is already stored; $file is the relative path.
                $path = $file;
                $originalName = pathinfo($path, PATHINFO_FILENAME);
                $absolutePath = Storage::disk('public')->path($path);
                $mime = File::mimeType($absolutePath);
                $size = File::size($absolutePath);
            } elseif ($file instanceof UploadedFile) {
                // Manually store the file.
                $path = $file->store('uploads/media', 'public');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $mime = $file->getMimeType();
                $size = $file->getSize();
            } else {
                return;
            }

            // Update the placeholder record with file details and business association.
            $this->record->update([
                // Save the full relative path (e.g. "uploads/media/filename.png")
                'file_name' => $path,
                'name' => $originalName,
                'mime_type' => $mime,
                'size' => $size,
                'model_id' => $this->businessId, // e.g. should be 25
                'model_type' => 'App\\Models\\Business',
            ]);
        }
    }
}
