<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResultResource\Pages;
use App\Filament\Resources\ResultResource\RelationManagers;
use App\Models\Result;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('method_num')
                    ->sortable(),
                Tables\Columns\TextColumn::make('method.id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit.unitsymbol.textde'),
                Tables\Columns\TextColumn::make('value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('additional_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('device_num')
                    ->searchable(),
                Tables\Columns\TextColumn::make('device_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('serialnumber')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quarter')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([

                Tables\Filters\Filter::make('Standard Ringversuch')->query(
                    function (Builder $query): Builder {
                        //return $query->where('year',date("Y"));
                        return $query->where('survey_id',config('app.survey'));
                    }
                ) ->label('Ringversuch '. config('app.survey'))->default(),

                Tables\Filters\SelectFilter::make('Ringversuch')
                    ->relationship('survey','id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->year} - {$record->quarter} ({$record->id})")
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
