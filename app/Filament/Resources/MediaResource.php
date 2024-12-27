<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Models\Media;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Media Manager';
    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('file_path')
                    ->label('File')
                    ->directory('uploads/media')
                    ->disk('public') // Ensure disk matches your storage setup
                    ->required()
                    ->maxSize(5120) // Limit file size to 5MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif']), // Restrict to specific types

                Forms\Components\TextInput::make('alt_text')->label('Alt Text'),
                Forms\Components\Textarea::make('caption')->label('Caption'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file_path')
                    ->label('Preview')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('file_name')->label('File Name'),
                Tables\Columns\TextColumn::make('alt_text')->label('Alt Text'),
                Tables\Columns\TextColumn::make('size')
                    ->label('Size')
                    ->formatStateUsing(fn($state) => number_format($state / 1024, 2) . ' KB'),
                Tables\Columns\TextColumn::make('uploaded_by')->label('Uploaded By'),
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
