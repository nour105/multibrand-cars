<?php

namespace App\Filament\AdminPanel\Resources;

use App\Filament\AdminPanel\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Leads';
    protected static ?string $pluralModelLabel = 'Leads';
    protected static ?string $navigationGroup = 'CRM';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Customer Info')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->required()
                            ->maxLength(50),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Financial Info (Optional)')
                    ->schema([
                        Forms\Components\Select::make('salary_range')
                            ->options([
                                '0-5000' => '0 – 5,000',
                                '5000-10000' => '5,000 – 10,000',
                                '10000-15000' => '10,000 – 15,000',
                                '15000+' => '15,000+',
                            ]),

                        Forms\Components\Toggle::make('has_loans'),

                        Forms\Components\Select::make('loan_type')
                            ->options([
                                'personal' => 'Personal',
                                'realestate' => 'Real Estate',
                                'both' => 'Both',
                            ]),

                        Forms\Components\Select::make('visa_limit')
                            ->options([
                                'below_5000' => 'Below 5,000',
                                '5000-10000' => '5,000 – 10,000',
                                '10000-15000' => '10,000 – 15,000',
                                '15000+' => '15,000+',
                            ]),

                        Forms\Components\TextInput::make('bank'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Selection & EMI')
                    ->schema([
                        Forms\Components\TextInput::make('emi_budget')
                            ->numeric()
                            ->disabled(),

                        Forms\Components\Toggle::make('emi_calculated')
                            ->disabled(),

                        Forms\Components\Select::make('car_id')
                            ->relationship('car', 'name')
                            ->searchable(),

                        Forms\Components\TextInput::make('purchase_timeline'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Consents')
                    ->schema([
                        Forms\Components\Toggle::make('marketing_consent'),
                        Forms\Components\Toggle::make('privacy_accepted')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone'),

                Tables\Columns\TextColumn::make('email'),

                Tables\Columns\TextColumn::make('car.name')
                    ->label('Selected Car')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('emi_budget')
                    ->label('EMI'),

                Tables\Columns\IconColumn::make('emi_calculated')
                    ->boolean()
                    ->label('EMI?'),

                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('emi_calculated')
                    ->label('EMI Calculated'),

                Tables\Filters\Filter::make('today')
                    ->query(fn ($query) =>
                        $query->whereDate('created_at', now())
                    ),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
