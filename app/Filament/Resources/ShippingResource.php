<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use App\Models\Shipping;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ShippingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ShippingResource\RelationManagers;

class ShippingResource extends Resource
{
    protected static ?string $model = Shipping::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Daten zur Adresse';
    protected static ?string $navigationLabel = 'Versandinformationen';

    protected static ?string $pluralModelLabel = 'Versandinformationen';
    protected static ?string $modelLabel = 'Versandinformation';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('address_id')
                //     ->relationship('address', 'name'),
                // Forms\Components\TextInput::make('shipType.textde')
                //     ->Label('Termin'),
                Forms\Components\Select::make('ship_format_id')
                    ->relationship('ship_format', 'textde'),
                Forms\Components\Select::make('language_id')
                    ->relationship('language', 'id'),
                Forms\Components\TextInput::make('priority')
                    ->numeric(),
                Forms\Components\TextInput::make('material')
                    ->numeric(),
                Forms\Components\TextInput::make('amount')
                    ->numeric(),
                Forms\Components\TextInput::make('note')
                    ->maxLength(100),
                Forms\Components\TextInput::make('weight')
                    ->numeric(),
                Forms\Components\TextInput::make('grp')
                    ->numeric(),
                Forms\Components\TextInput::make('lot')
                    ->numeric(),
                Forms\Components\TextInput::make('packing')
                    ->numeric(),

                Forms\Components\TextInput::make('year')
                    ->numeric(),
                Forms\Components\TextInput::make('quarter')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('address.name')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('ship_format.textde')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('language_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('priority')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('material')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('note')
                    ->searchable(),
                Tables\Columns\TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grp')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lot')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('packing')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quarter')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->paginated()
            ->paginationPageOptions([10, 25, 50])


            ->filters([

                Tables\Filters\SelectFilter::make('survey_id')
                        ->label('Ringversuch')
                        ->options(
                            Survey::query()
                                ->orderByDesc('year')
                                ->orderByDesc('quarter')
                                ->get()
                                ->mapWithKeys(fn ($survey) => [
                                    $survey->id => "{$survey->year} / Q{$survey->quarter}",
                                ])
                        )
                        ->default(Survey::where('def_survey', true)->value('id'))
                        ->searchable(),

            ])



            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShippings::route('/'),
            'create' => Pages\CreateShipping::route('/create'),
            'edit' => Pages\EditShipping::route('/{record}/edit'),
        ];
    }
}
