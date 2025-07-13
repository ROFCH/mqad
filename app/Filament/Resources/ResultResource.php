<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Result;
use App\Models\Survey;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ResultResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ResultResource\RelationManagers;

class ResultResource extends Resource
{
    protected static ?string $model = Result::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Daten zur Adresse';
    protected static ?string $navigationLabel = 'Resultate';

    protected static ?string $pluralModelLabel = 'Resultate';
    protected static ?string $modelLabel = 'Resultat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('survey_id')
                    ->numeric(),
                Forms\Components\Select::make('address_id')
                    ->relationship('address', 'name'),
                Forms\Components\TextInput::make('method_num')
                    ->numeric(),
                Forms\Components\Select::make('method_id')
                    ->relationship('method', 'id'),
                Forms\Components\Select::make('unit_id')
                    ->relationship('unit', 'id'),
                Forms\Components\TextInput::make('value')
                    ->numeric(),
                Forms\Components\TextInput::make('additional_value')
                    ->numeric(),
                Forms\Components\TextInput::make('device_num')
                    ->maxLength(10),
                Forms\Components\TextInput::make('device_id')
                    ->numeric(),
                Forms\Components\TextInput::make('serialnumber')
                    ->maxLength(10),
                Forms\Components\TextInput::make('department')
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
                // Tables\Columns\TextColumn::make('survey_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('address.id')
                    ->searchable(),

                Tables\Columns\TextColumn::make('address_display')
                    ->label('Adresse')
                    ->getStateUsing(function ($record) {
                        $name = trim($record->address->name ?? '');
                        $city = trim($record->address->city ?? '');

                        return $name && $city
                            ? "{$name}, {$city}"
                            : ($name ?: $city ?: '-');
                    }) ,


                // Tables\Columns\TextColumn::make('method_num')
                //     ->sortable(),
                Tables\Columns\TextColumn::make('method.id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('method.substance.product.code')
                    ->searchable(isIndividual: true),              
                Tables\Columns\TextColumn::make('method.substance.textde')
                    ->searchable(),
                Tables\Columns\TextColumn::make('method.instrument.textde')
                    ->searchable(),

                Tables\Columns\TextColumn::make('value')
                    ->label("Wert")
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 3, '.', '')),
                
                Tables\Columns\TextColumn::make('unit.unitsymbol.textde')
                    ->label("Einheit"),

                Tables\Columns\TextColumn::make('additional_value')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('device_num')
                    ->searchable(),
                Tables\Columns\TextColumn::make('device_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('serialnumber')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('department')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
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
            'index' => Pages\ListResults::route('/'),
            'create' => Pages\CreateResult::route('/create'),
            'edit' => Pages\EditResult::route('/{record}/edit'),
        ];
    }
}
