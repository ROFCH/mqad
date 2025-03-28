<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatcodeResource\Pages;
use App\Filament\Resources\StatcodeResource\RelationManagers;
use App\Models\Statcode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatcodeResource extends Resource
{
    protected static ?string $model = Statcode::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Auswertungen';
    protected static ?string $navigationLabel = 'Statistiken Urinsediment';

    protected static ?string $pluralModelLabel = 'Statistiken Urinsediment';
    protected static ?string $modelLabel = 'Statistiken Urinsediment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('survey_id')
                    ->numeric(),
                Forms\Components\TextInput::make('code_code')
                    ->numeric(),
                Forms\Components\TextInput::make('s1')
                    ->numeric(),
                Forms\Components\TextInput::make('s2')
                    ->numeric(),
                Forms\Components\TextInput::make('s3')
                    ->numeric(),
                Forms\Components\TextInput::make('s4')
                    ->numeric(),
                Forms\Components\TextInput::make('s5')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort(function (Builder $query): Builder {
                return $query
                    ->orderBy('survey_id','desc')
                    ->orderBy('code_code','asc');
            })
            

            ->columns([
                Tables\Columns\TextColumn::make('survey_id')
                    ->label('Ringversuch'),
                Tables\Columns\TextColumn::make('survey.quarter')
                    ->label('Quartal'),    
                Tables\Columns\TextColumn::make('survey.year')
                    ->label('Jahr')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('code_code')
                    ->label('Code')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('code.textde')
                    ->label('Beschreibung'),    
                Tables\Columns\TextColumn::make('s1')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('s2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('s3')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('s4')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('s5')
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
            ])
            ->filters([
                Tables\Filters\Filter::make('Letztes_Jahr')->query(
                    function (Builder $query): Builder {
                        return $query->where('survey_id',119);
                    }
                ) ->label('Letztes Jahr'),
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
            'index' => Pages\ListStatcodes::route('/'),
            'create' => Pages\CreateStatcode::route('/create'),
            'edit' => Pages\EditStatcode::route('/{record}/edit'),
        ];
    }
}
