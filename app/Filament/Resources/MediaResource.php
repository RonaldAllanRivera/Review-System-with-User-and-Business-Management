<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Models\Business;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Models\Media;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Media Library';
    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // Select the business for associating images
                Forms\Components\Select::make('model_id')
                    ->label('Select Business')
                    ->options(Business::pluck('business_name', 'id'))
                    ->searchable()
                    ->required()
                    ->helperText('Choose the business to associate images with'),

                // File Upload using Filament's FileUpload component, bound to "file_name"
                FileUpload::make('file_name')
                    ->label('Upload Image')
                    ->directory('uploads/media') // Files stored in storage/app/public/uploads/media
                    ->image()
                    ->helperText('Upload an image for the selected business'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file_name')
                    ->label('Preview')
                    ->getStateUsing(fn($record) => Storage::disk('public')->url($record->file_name))
                    ->height(50)
                    ->width(50),

                Tables\Columns\TextColumn::make('file_name')
                    ->label('File Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('model_id')
                    ->label('Associated Business')
                    ->formatStateUsing(fn($state) => Business::find($state)?->business_name ?? 'No Business'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
