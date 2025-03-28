<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatmethodResource\Pages;
use App\Filament\Resources\StatmethodResource\RelationManagers;
use App\Models\Statmethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatmethodResource extends Resource
{
    protected static ?string $model = Statmethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationLabel = 'Statistik quantitativ';
    protected static ?string $navigationGroup = 'Zielwerte';

    protected static ?string $pluralModelLabel = 'Statistik quantitativ';
    protected static ?string $modelLabel = 'Statistik quantitativ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('method_id')
                    ->relationship('method', 'id'),
                Forms\Components\Select::make('survey_id')
                    ->relationship('survey', 'id'),
                Forms\Components\TextInput::make('sample')
                    ->numeric(),
                Forms\Components\TextInput::make('cnt_valid')
                    ->numeric(),
                Forms\Components\TextInput::make('cnt_error')
                    ->numeric(),
                Forms\Components\TextInput::make('cnt_novalue')
                    ->numeric(),
                Forms\Components\TextInput::make('target')
                    ->numeric(),
                Forms\Components\TextInput::make('calc_durch')
                    ->numeric(),
                Forms\Components\TextInput::make('calc_median')
                    ->numeric(),
                Forms\Components\TextInput::make('calc_cv')
                    ->numeric(),
                Forms\Components\TextInput::make('calc_q10')
                    ->numeric(),
                Forms\Components\TextInput::make('calc_q25')
                    ->numeric(),
                Forms\Components\TextInput::make('calc_q75')
                    ->numeric(),
                Forms\Components\TextInput::make('calc_q90')
                    ->numeric(),
                Forms\Components\TextInput::make('cnt_ok')
                    ->numeric(),
                Forms\Components\TextInput::make('cnt_insufficient')
                    ->numeric(),
                Forms\Components\TextInput::make('cnt_outlier')
                    ->numeric(),
                Forms\Components\TextInput::make('histogram')
                    ->maxLength(200),
                Forms\Components\TextInput::make('Unit')
                    ->maxLength(50),
                Forms\Components\TextInput::make('decimals')
                    ->numeric(),
                Forms\Components\TextInput::make('tolerance')
                    ->numeric(),
                Forms\Components\TextInput::make('sample_code')
                    ->maxLength(3),
                Forms\Components\TextInput::make('substancede')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('method.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('method.substancede')
                    ->searchable(),
                Tables\Columns\TextColumn::make('method.instrumentde') ,   
                Tables\Columns\TextColumn::make('survey.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sample')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cnt_valid')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cnt_error')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cnt_novalue')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('calc_durch')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('calc_median')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('calc_cv')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('calc_q10')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('calc_q25')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('calc_q75')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('calc_q90')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cnt_ok')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cnt_insufficient')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cnt_outlier')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('histogram'),
                Tables\Columns\TextColumn::make('Unit')
                    ,
                Tables\Columns\TextColumn::make('decimals')
                    ,
                Tables\Columns\TextColumn::make('tolerance')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sample_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('substancede')
                    ,
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ]);
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ]);
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
            'index' => Pages\ListStatmethods::route('/'),
            'create' => Pages\CreateStatmethod::route('/create'),
            'edit' => Pages\EditStatmethod::route('/{record}/edit'),
        ];
    }
}
