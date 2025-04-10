<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessResource\Pages;
use App\Models\Business;
use App\Models\Media;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ColorPicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Filament\Forms\Components\ViewField;




class BusinessResource extends Resource
{
    protected static ?string $model = Business::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Businesses';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(1)->schema([
                Tabs::make('Business Details')->tabs([
                    // General Information Tab
                    Tab::make('General Information')->schema([
                        Select::make('business_type')
                            ->label('Business Type')
                            ->options([
                                'Business' => 'Business',
                                'Under Corporate' => 'Under Corporate',
                            ])
                            ->required(),

                        TextInput::make('business_name')
                            ->label('Business Name')
                            ->required()
                            ->maxLength(256)
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state)))
                            ->debounce(500),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->helperText('The slug will be auto-generated based on the Business Name but can be manually edited.'),

                        // --- Featured Image Selection ---
                        // Featured Image Selection: Use a select field to pick a media record
                        Select::make('featured_image_id')
                            ->label('Featured Image')
                            ->options(function (callable $get, ?\App\Models\Business $record) {
                                $businessId = $record?->id ?? $get('id');
                                $selectedId = $get('featured_image_id');

                                $query = \App\Models\Media::query()
                                    ->where('collection_name', 'business_images')
                                    ->when($businessId, fn($q) => $q->where('model_id', $businessId));

                                // Get filtered images
                                $options = $query->orderBy('id', 'desc')->pluck('file_name', 'id')->toArray();

                                // Ensure currently selected ID is present in the list (even if not matching filter)
                                if ($selectedId && !array_key_exists($selectedId, $options)) {
                                    $selectedMedia = \App\Models\Media::find($selectedId);
                                    if ($selectedMedia) {
                                        $options = [$selectedId => $selectedMedia->file_name] + $options;
                                    }
                                }

                                // Fallback if still empty
                                return $options ?: [null => 'No images found for this business'];
                            })
                            ->searchable()
                            ->reactive()
                            ->nullable()
                            ->helperText('Only shows images uploaded for this business.'),



                        Placeholder::make('featured_image_preview')
                            ->label('Image Preview')
                            ->content(function (callable $get) {
                                $mediaId = $get('featured_image_id');
                                if ($mediaId) {
                                    $media = \App\Models\Media::find($mediaId);
                                    if ($media) {
                                        $url = Storage::disk('public')->url($media->file_name);
                                        return new HtmlString("<img src='{$url}' style='max-height:150px;' />");
                                    }
                                }
                                return new HtmlString("No image selected");
                            })
                            ->columnSpan('full'),

                        // --- End Featured Image Selection ---

                    ]),

                    // Address Tab
                    Tab::make('Address')->schema([
                        TextInput::make('business_address1')
                            ->label('Address Line 1')
                            ->maxLength(256),
                        TextInput::make('business_address2')
                            ->label('Address Line 2')
                            ->maxLength(256),
                        TextInput::make('business_city')
                            ->label('City')
                            ->maxLength(256),
                        Select::make('business_state')
                            ->label('State/Province')
                            ->options([
                                'AL' => 'Alabama',
                                'AK' => 'Alaska',
                                // … other states/provinces …
                                'YT' => 'Yukon',
                            ])
                            ->required()
                            ->placeholder('Select a state or province')
                            ->searchable(),
                        TextInput::make('business_zip')
                            ->label('Zip Code')
                            ->maxLength(45),
                    ]),

                    // Contact Information Tab
                    Tab::make('Contact Information')->schema([
                        TextInput::make('business_contact_first_name')
                            ->label('Contact First Name')
                            ->maxLength(256),
                        TextInput::make('business_contact_last_name')
                            ->label('Contact Last Name')
                            ->maxLength(256),
                        TextInput::make('business_contact_email')
                            ->label('Contact Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('business_contact_email_cc')
                            ->label('CC Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('business_contact_email_bcc')
                            ->label('BCC Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('business_contact_phone')
                            ->label('Contact Phone')
                            ->maxLength(100),
                    ]),

                    // Reports Tab
                    Tab::make('Reports')->schema([
                        Toggle::make('immediate_report')
                            ->label('Immediate Report')
                            ->default(false)
                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),
                        Toggle::make('immediate_report_rating1')
                            ->label('Immediate Report Rating 1')
                            ->default(false)
                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),
                        // … other toggles as needed …
                        Toggle::make('immediate_report_rating2')
                            ->label('Immediate Report Rating 2')
                            ->default(false)
                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),
                        Toggle::make('immediate_report_rating3')
                            ->label('Immediate Report Rating 3')
                            ->default(false)
                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),
                        Toggle::make('immediate_report_rating4')
                            ->label('Immediate Report Rating 4')
                            ->default(false)
                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),
                        Toggle::make('immediate_report_rating5')
                            ->label('Immediate Report Rating 5')
                            ->default(false)
                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),
                        Toggle::make('special_offers')
                            ->label('Special Offers')
                            ->default(false)
                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),
                        Toggle::make('weekly_report')
                            ->label('Weekly Report')
                            ->default(false)
                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),
                        Toggle::make('weekly_report_flat')
                            ->label('Weekly Report Flat')
                            ->default(false)
                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),
                        Toggle::make('monthly_report')
                            ->label('Monthly Report')
                            ->default(false)
                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),
                    ]),

                    // Settings Tab
                    Tab::make('Settings')->schema([
                        ColorPicker::make('header_color')
                            ->label('Header Color'),
                        ColorPicker::make('border_color')
                            ->label('Border Color'),
                        TextInput::make('youtube_link')
                            ->label('YouTube Link')
                            ->url()
                            ->nullable()
                            ->helperText('Optional: Add a YouTube link for your business.'),
                        Toggle::make('youtube_autoplay')
                            ->label('YouTube Autoplay')
                            ->default(false)
                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),
                        Select::make('user_id')
                            ->label('Assigned User')
                            ->relationship('owner', 'email', fn($query) => $query->whereIn('role', ['admin', 'editor']))
                            ->required(),
                    ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable()->label('ID'),
            Tables\Columns\TextColumn::make('business_name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('business_type')->sortable(),
            Tables\Columns\TextColumn::make('owner.email')->label('Assigned User')->sortable(),
            // Show a thumbnail for the featured image via relationship:
            Tables\Columns\ImageColumn::make('featuredImage.file_name')
                ->label('Featured Image')
                ->disk('public')
                ->height(50)
                ->width(50),
        ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('View Frontend')
                    ->label('View Frontend')
                    ->url(fn(Business $record): string => route('business.show', ['id' => $record->id, 'slug' => $record->slug]))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-link'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBusinesses::route('/'),
            'create' => Pages\CreateBusiness::route('/create'),
            'edit' => Pages\EditBusiness::route('/{record}/edit'),
        ];
    }
}
