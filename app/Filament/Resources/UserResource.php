<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Validation\Rule;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(1) // Create a single-column grid to expand the layout
                    ->schema([
                        Forms\Components\Tabs::make('User Details')
                            ->tabs([
                                // Personal Information Tab
                                Forms\Components\Tabs\Tab::make('Personal Information')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('First Name')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('middle_name')
                                            ->label('Middle Name')
                                            ->maxLength(75),

                                        Forms\Components\TextInput::make('last_name')
                                            ->label('Last Name')
                                            ->required()
                                            ->maxLength(75),

                                        Forms\Components\Select::make('gender')
                                            ->options([
                                                'm' => 'Male',
                                                'f' => 'Female',
                                            ])
                                            ->required()
                                            ->default('Male'),

                                        Forms\Components\TextInput::make('grade')
                                            ->label('Grade')
                                            ->maxLength(200),
                                    ]),

                                // Account Details Tab
                                Forms\Components\Tabs\Tab::make('Account Details')
                                    ->schema([
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->reactive()
                                            ->rules([
                                                'unique:users,email', // Simple unique rule directly using the database
                                            ])
                                            ->helperText('Ensure this email is unique.'),

                                        Forms\Components\TextInput::make('secondary_email')
                                            ->label('Secondary Email')
                                            ->email()
                                            ->maxLength(200),

                                        Forms\Components\Select::make('role')
                                            ->options([
                                                'admin' => 'Admin',
                                                'editor' => 'Editor',
                                                'user' => 'User',
                                            ])
                                            ->required()
                                            ->default('user'),

                                        Forms\Components\TextInput::make('password')
                                            ->password()
                                            ->minLength(8)
                                            ->maxLength(100)
                                            ->dehydrated(fn($state) => !empty ($state)) // Only update the password if the field is not empty
                                            ->placeholder(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord ? 'Leave blank to keep current password' : null)
                                            ->required(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord), // Only require on CreateUser page

                                    ]),

                                // Contact Information Tab
                                Forms\Components\Tabs\Tab::make('Contact Information')
                                    ->schema([
                                        Forms\Components\TextInput::make('phone_home')
                                            ->label('Home Phone')
                                            ->maxLength(250),

                                        Forms\Components\TextInput::make('mobile')
                                            ->label('Mobile Phone')
                                            ->maxLength(250),

                                        Forms\Components\TextInput::make('team_head_phone')
                                            ->label('Team Head Phone')
                                            ->maxLength(200),

                                        Forms\Components\TextInput::make('team_head')
                                            ->label('Team Head')
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('team_name')
                                            ->label('Team Name')
                                            ->maxLength(75),
                                    ]),

                                // Address Tab
                                Forms\Components\Tabs\Tab::make('Address')
                                    ->schema([
                                        Forms\Components\TextInput::make('address1')
                                            ->label('Address Line 1')
                                            ->maxLength(250),

                                        Forms\Components\TextInput::make('address2')
                                            ->label('Address Line 2')
                                            ->maxLength(250),

                                        Forms\Components\TextInput::make('city')
                                            ->maxLength(250),

                                        Forms\Components\Select::make('state')
                                            ->label('State/Province')
                                            ->options(fn(callable $get) => match ($get('country')) {
                                                'United States' => [
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
                                                ],
                                                'Canada' => [
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
                                                ],
                                                default => [],
                                            })
                                            ->required()
                                            ->searchable(),

                                        Forms\Components\TextInput::make('zip')
                                            ->maxLength(250),

                                        Forms\Components\Select::make('country')
                                            ->label('Country')
                                            ->options([
                                                'United States' => 'United States',
                                                'Canada' => 'Canada',
                                            ])
                                            ->required()
                                            ->reactive()
                                            ->default('United States'),
                                    ]),

                                // Additional Details Tab
                                Forms\Components\Tabs\Tab::make('Additional Details')
                                    ->schema([
                                        Forms\Components\TextInput::make('program_name')
                                            ->label('Program Name')
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('parent_name')
                                            ->label('Parent Name')
                                            ->maxLength(200),

                                        Forms\Components\TextInput::make('child_name')
                                            ->label('Child Name')
                                            ->maxLength(200),

                                        Forms\Components\TextInput::make('company')
                                            ->label('Company')
                                            ->maxLength(250),
                                    ]),

                                // Status Tab
                                Forms\Components\Tabs\Tab::make('Status')
                                    ->schema([
                                        Forms\Components\Select::make('status')
                                            ->options([
                                                '0' => 'Inactive',
                                                '1' => 'Active',
                                            ])
                                            ->required()
                                            ->default(0),

                                        Forms\Components\Toggle::make('email_sent')
                                            ->label('Email Sent')
                                            ->default(false),

                                        Forms\Components\Toggle::make('csv_sent')
                                            ->label('CSV Sent')
                                            ->default(false),

                                        Forms\Components\Toggle::make('member')
                                            ->label('Member')
                                            ->default(false),
                                    ]),
                            ]),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),

                Tables\Columns\TextColumn::make('name')
                    ->label('First Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('last_name')
                    ->label('Last Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->sortable()
                    ->badge()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created At'),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'editor' => 'Editor',
                        'user' => 'User',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
