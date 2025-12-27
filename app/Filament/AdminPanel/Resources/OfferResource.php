<?php

namespace App\Filament\AdminPanel\Resources;

use App\Filament\AdminPanel\Resources\OfferResource\Pages;
use App\Models\Offer;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;
    protected static ?string $navigationIcon = 'heroicon-o-check';
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationLabel = 'Offers';

    public static function form(Form $form): Form
    {
        return $form->schema([
Forms\Components\TextInput::make('title')
    ->required()
    ->reactive()
    ->afterStateUpdated(fn ($state, callable $set) =>
        $set('slug', \Illuminate\Support\Str::slug($state))
    ),
            Forms\Components\TextInput::make('slug')
    ->required()
    ->dehydrated()
    ->unique(ignoreRecord: true),

            Forms\Components\Textarea::make('description'),

     Forms\Components\Select::make('brand_ids')
    ->label('Brands')
    ->multiple()
    ->relationship('brands', 'name')
    ->required()
    ->reactive()
    ->afterStateUpdated(fn ($set) => $set('cars', [])),


    Forms\Components\Select::make('cars')
    ->label('Cars')
    ->multiple()
    ->relationship(
        name: 'cars',
        titleAttribute: 'name',
        modifyQueryUsing: function ($query, $get) {
            $brandIds = $get('brand_ids');

            if (!empty($brandIds)) {
                $query->whereIn('brand_id', $brandIds);
            }
        }
    )
    ->required()
    ->reactive(),

Forms\Components\Placeholder::make('cars_prices')
    ->label('Selected Cars Prices')
    ->content(function ($get) {
        $carIds = $get('cars');

        if (empty($carIds)) {
            return '-';
        }

        return Car::whereIn('id', $carIds)
            ->get()
            ->map(function ($car) {
                $price = "{$car->price} {$car->currency}";

               if ($car->emi_monthly) {
    $price .= " | EMI: {$car->emi_monthly} {$car->currency} )";
}

                return "{$car->name}: {$price}";
            })
            ->implode(' | ');
    }),



            Forms\Components\FileUpload::make('banners')
                ->label('Offer Banners')
                ->image()
                ->multiple()
                ->directory('offers/banners')
                ->reorderable(),

            Forms\Components\DatePicker::make('start_date')->required(),
            Forms\Components\DatePicker::make('end_date')->required(),
        ]);
    }

  
   
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('slug')
    ->searchable()
    ->sortable(),
Tables\Columns\TextColumn::make('brands.name')
    ->label('Brands')
    ->badge()
    ->separator(', ')     , 
          Tables\Columns\TextColumn::make('cars_count')->label('Cars')->counts('cars'),
            Tables\Columns\TextColumn::make('start_date')->date(),
            Tables\Columns\TextColumn::make('end_date')->date(),
        ])
        ->actions([Tables\Actions\EditAction::make()])
        ->bulkActions([Tables\Actions\DeleteBulkAction::make()])
        ->emptyStateActions([Tables\Actions\CreateAction::make()]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
