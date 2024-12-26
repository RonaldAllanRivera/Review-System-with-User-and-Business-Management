<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Business;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\BusinessResource\Pages;

class BusinessResource extends Resource
{
    protected static ?string $model = Business::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Businesses';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(1)
                    ->schema([
                        Forms\Components\Tabs::make('Business Details')
                            ->tabs([
                                // General Information Tab
                                Forms\Components\Tabs\Tab::make('General Information')
                                    ->schema([
                                        Forms\Components\Select::make('business_type')
                                            ->label('Business Type')
                                            ->options([
                                                'Business' => 'Business',
                                                'Under Corporate' => 'Under Corporate',
                                            ])
                                            ->required(),

                                        Forms\Components\TextInput::make('business_name')
                                            ->label('Business Name')
                                            ->required()
                                            ->maxLength(256)
                                            ->reactive() // Automatically listens to changes
                                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state)))
                                            ->debounce(500), // Add debounce directly to the field

                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->helperText('The slug will be auto-generated based on the Business Name but can be manually edited.'),


                                    ]),

                                // Address Tab
                                Forms\Components\Tabs\Tab::make('Address')
                                    ->schema([
                                        Forms\Components\TextInput::make('business_address1')
                                            ->label('Address Line 1')
                                            ->maxLength(256),

                                        Forms\Components\TextInput::make('business_address2')
                                            ->label('Address Line 2')
                                            ->maxLength(256),

                                        Forms\Components\TextInput::make('business_city')
                                            ->label('City')
                                            ->maxLength(256),

                                        Forms\Components\Select::make('business_state')
                                            ->label('State/Province')
                                            ->options([
                                                'AL' => 'Alabama',
                                                'AK' => 'Alaska',
                                                'AZ' => 'Arizona',
                                                'AR' => 'Arkansas',
                                                'CA' => 'California',
                                                'CO' => 'Colorado',
                                                'CT' => 'Connecticut',
                                                'DE' => 'Delaware',
                                                'FL' => 'Florida',
                                                'GA' => 'Georgia',
                                                'HI' => 'Hawaii',
                                                'ID' => 'Idaho',
                                                'IL' => 'Illinois',
                                                'IN' => 'Indiana',
                                                'IA' => 'Iowa',
                                                'KS' => 'Kansas',
                                                'KY' => 'Kentucky',
                                                'LA' => 'Louisiana',
                                                'ME' => 'Maine',
                                                'MD' => 'Maryland',
                                                'MA' => 'Massachusetts',
                                                'MI' => 'Michigan',
                                                'MN' => 'Minnesota',
                                                'MS' => 'Mississippi',
                                                'MO' => 'Missouri',
                                                'MT' => 'Montana',
                                                'NE' => 'Nebraska',
                                                'NV' => 'Nevada',
                                                'NH' => 'New Hampshire',
                                                'NJ' => 'New Jersey',
                                                'NM' => 'New Mexico',
                                                'NY' => 'New York',
                                                'NC' => 'North Carolina',
                                                'ND' => 'North Dakota',
                                                'OH' => 'Ohio',
                                                'OK' => 'Oklahoma',
                                                'OR' => 'Oregon',
                                                'PA' => 'Pennsylvania',
                                                'RI' => 'Rhode Island',
                                                'SC' => 'South Carolina',
                                                'SD' => 'South Dakota',
                                                'TN' => 'Tennessee',
                                                'TX' => 'Texas',
                                                'UT' => 'Utah',
                                                'VT' => 'Vermont',
                                                'VA' => 'Virginia',
                                                'WA' => 'Washington',
                                                'WV' => 'West Virginia',
                                                'WI' => 'Wisconsin',
                                                'WY' => 'Wyoming',
                                                'AB' => 'Alberta',
                                                'BC' => 'British Columbia',
                                                'MB' => 'Manitoba',
                                                'NB' => 'New Brunswick',
                                                'NL' => 'Newfoundland and Labrador',
                                                'NS' => 'Nova Scotia',
                                                'ON' => 'Ontario',
                                                'PE' => 'Prince Edward Island',
                                                'QC' => 'Quebec',
                                                'SK' => 'Saskatchewan',
                                                'NT' => 'Northwest Territories',
                                                'NU' => 'Nunavut',
                                                'YT' => 'Yukon',
                                            ])
                                            ->required()
                                            ->placeholder('Select a state or province')
                                            ->searchable(),

                                        Forms\Components\TextInput::make('business_zip')
                                            ->label('Zip Code')
                                            ->maxLength(45),
                                    ]),

                                // Contact Information Tab
                                Forms\Components\Tabs\Tab::make('Contact Information')
                                    ->schema([
                                        Forms\Components\TextInput::make('business_contact_first_name')
                                            ->label('Contact First Name')
                                            ->maxLength(256),

                                        Forms\Components\TextInput::make('business_contact_last_name')
                                            ->label('Contact Last Name')
                                            ->maxLength(256),

                                        Forms\Components\TextInput::make('business_contact_email')
                                            ->label('Contact Email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('business_contact_email_cc')
                                            ->label('CC Email')
                                            ->email()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('business_contact_email_bcc')
                                            ->label('BCC Email')
                                            ->email()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('business_contact_phone')
                                            ->label('Contact Phone')
                                            ->maxLength(100),
                                    ]),

                                // Reports Tab
                                Forms\Components\Tabs\Tab::make('Reports')
                                    ->schema([
                                        Forms\Components\Toggle::make('immediate_report')
                                            ->label('Immediate Report')
                                            ->default(false)
                                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),

                                        Forms\Components\Toggle::make('immediate_report_rating1')
                                            ->label('Immediate Report Rating 1')
                                            ->default(false)
                                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),

                                        Forms\Components\Toggle::make('immediate_report_rating2')
                                            ->label('Immediate Report Rating 2')
                                            ->default(false)
                                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),

                                        Forms\Components\Toggle::make('immediate_report_rating3')
                                            ->label('Immediate Report Rating 3')
                                            ->default(false)
                                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),

                                        Forms\Components\Toggle::make('immediate_report_rating4')
                                            ->label('Immediate Report Rating 4')
                                            ->default(false)
                                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),

                                        Forms\Components\Toggle::make('immediate_report_rating5')
                                            ->label('Immediate Report Rating 5')
                                            ->default(false)
                                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),

                                        Forms\Components\Toggle::make('special_offers')
                                            ->label('Special Offers')
                                            ->default(false)
                                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),

                                        Forms\Components\Toggle::make('weekly_report')
                                            ->label('Weekly Report')
                                            ->default(false)
                                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),

                                        Forms\Components\Toggle::make('weekly_report_flat')
                                            ->label('Weekly Report Flat')
                                            ->default(false)
                                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),

                                        Forms\Components\Toggle::make('monthly_report')
                                            ->label('Monthly Report')
                                            ->default(false)
                                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),
                                    ]),



                                // Settings Tab
                                Forms\Components\Tabs\Tab::make('Settings')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('header_color')
                                            ->label('Header Color'),

                                        Forms\Components\ColorPicker::make('border_color')
                                            ->label('Border Color'),

                                        Forms\Components\TextInput::make('youtube_link')
                                            ->label('YouTube Link')
                                            ->url()
                                            ->nullable()
                                            ->helperText('Optional: Add a YouTube link for your business.'),

                                        Forms\Components\Toggle::make('youtube_autoplay')
                                            ->label('YouTube Autoplay')
                                            ->default(false)
                                            ->dehydrateStateUsing(fn($state) => $state ? '1' : '0'),

                                        Forms\Components\Select::make('user_id')
                                            ->label('Assigned User')
                                            ->relationship('owner', 'email', function ($query) {
                                                return $query->whereIn('role', ['admin', 'editor']);
                                            })
                                            ->required(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->label('ID'),
                Tables\Columns\TextColumn::make('business_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('business_type')->sortable(),
                Tables\Columns\TextColumn::make('owner.email')->label('Assigned User')->sortable(),
            ])
            ->filters([])
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
