<?php

namespace App\Filament\AdminPanel\Resources;

use App\Filament\AdminPanel\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationLabel = 'Brands';

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
    ->unique(ignoreRecord: true)
    ->dehydrated(),

  Forms\Components\FileUpload::make('logo')
    ->label('Brand Logo')
    ->image()
    ->disk('public')                 // important!
    ->directory('brands/logos')      // store in storage/app/public/brands/logos
    ->visibility('public')           // makes it publicly accessible
    ->preserveFilenames()            // keeps original file name
    ->required(),

        Forms\Components\RichEditor::make('biography')
            ->label('Brand Biography')
            ->columnSpanFull(),

     Forms\Components\FileUpload::make('banners')
    ->label('Brand Banners')
    ->multiple()
    ->image()
    ->disk('public')
    ->directory('brands/banners')
    ->visibility('public')
    ->reorderable()
    ->columnSpanFull(),

    ]);
}


public static function table(Table $table): Table
{
    return $table->columns([
        Tables\Columns\TextColumn::make('id')->sortable(),
        Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
Tables\Columns\ImageColumn::make('logo')
    ->disk('public'),
    Tables\Columns\TextColumn::make('banners')
    ->label('Banners')
    ->formatStateUsing(function ($state) {
        if (!$state) return '';
        return collect($state)->map(fn($b) => '<img src="'.asset('storage/'.$b).'" style="height:50px;margin-right:5px">')->implode('');
    })
    ->html(),

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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
