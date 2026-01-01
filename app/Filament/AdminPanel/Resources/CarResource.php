<?php

namespace App\Filament\AdminPanel\Resources;

use App\Filament\AdminPanel\Resources\CarResource\Pages;
use App\Models\Car;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationLabel = 'Cars';

    public static function form(Form $form): Form
    {
        return $form->schema([
      Forms\Components\TextInput::make('name')
    ->required()
    ->live(onBlur: true)
    ->afterStateUpdated(fn ($state, callable $set) =>
        $set('slug', \Illuminate\Support\Str::slug($state))
    ),

Forms\Components\TextInput::make('slug')
    ->required()
    ->unique(ignoreRecord: true),

Forms\Components\Select::make('brand_id')
    ->relationship('brand', 'name')
    ->required(),

Forms\Components\Textarea::make('description')
    ->label('Short Description'),

Forms\Components\RichEditor::make('content')
    ->label('Detailed Content')
    ->disableAllToolbarButtons() ,


Forms\Components\Repeater::make('specifications')
    ->schema([
        Forms\Components\TextInput::make('key')->label('Spec Name'),
        Forms\Components\TextInput::make('value')->label('Spec Value'),
    ])
    ->columns(2),
Forms\Components\FileUpload::make('banner_image')
    ->label('Car Banner Image')
    ->image()
    ->disk('public')
    ->directory('cars/banner'),
    Forms\Components\FileUpload::make('card_image')
    ->label('Car Card Image')
    ->image()
    ->disk('public')
    ->directory('cars/card')
    ->helperText('Used in car listing cards (not banner)'),
    

Forms\Components\TextInput::make('price')
    ->label('Cash Price')
    ->placeholder('Enter price'),

Forms\Components\Select::make('currency')
    ->label('Currency')
    ->options([
        'SAR' => 'SAR',
        'USD' => '$',
        'EUR' => '€',
    ])
    ->default('SAR'),


Forms\Components\TextInput::make('emi_monthly')
    ->label('EMI Price (Monthly)')
    ->placeholder('Monthly installment amount'),
    
Forms\Components\Select::make('currency')
    ->label('Currency')
    ->options([
        'SAR' => 'SAR',
        'USD' => '$',
        'EUR' => '€',
    ])
    ->default('SAR'),

Forms\Components\Repeater::make('available_trims')
    ->label('Available Trims')
    ->schema([
        Forms\Components\TextInput::make('trim_name')->label('Trim Name'),
    ]),
    Forms\Components\Repeater::make('available_showrooms')
    ->label('Available in this Showroom')
    ->schema([
        Forms\Components\TextInput::make('showroom_name')
            ->label('Showroom Name')
            ->required(),
    ])
    ->columnSpanFull(),


Forms\Components\Repeater::make('colors')
    ->label('Available Colors')
    ->schema([
        Forms\Components\TextInput::make('color_name')->label('Color Name'),
    ]),

Forms\Components\Repeater::make('features')
    ->label('Features')
    ->schema([
        Forms\Components\TextInput::make('feature_name')->label('Feature'),
    ]),

Forms\Components\FileUpload::make('interior_images')
    ->multiple()->image()->disk('public')->directory('cars/interior')->reorderable(),

Forms\Components\FileUpload::make('exterior_images')
    ->multiple()->image()->disk('public')->directory('cars/exterior')->reorderable(),

Forms\Components\TextInput::make('video_url')->label('Video URL (YouTube/Vimeo)'),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('brand.name')->label('Brand')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y H:i'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ])
        ->emptyStateActions([
            Tables\Actions\CreateAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
