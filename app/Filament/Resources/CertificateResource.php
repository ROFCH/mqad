<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Certificate;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CertificateResource\Pages;
use App\Filament\Resources\CertificateResource\RelationManagers;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Daten zur Adresse';
    protected static ?string $navigationLabel = 'Zertifikate';

    protected static ?string $pluralModelLabel = 'Zertifikate';
    protected static ?string $modelLabel = 'Zertifikat';

    public static function form(Form $form): Form
    {
        return $form
            
            ->schema([
                Forms\Components\Select::make('address_id')
                    ->label('Teilnehmer')
                    ->relationship('address', 'id')
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} - {$record->name}")
                    ->disabled(),
                Forms\Components\Select::make('substance_id')
                    ->columnStart(1)
                    ->label('Substanz')
                    ->relationship('substance', 'id')
                    ->preload()
                    ->optionsLimit(1000)
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->textde} ({$record->id})"),
                Forms\Components\TextInput::make('success')
                    ->columnStart(1)
                    ->label('Erfolg'),
                Forms\Components\TextInput::make('participation')
                    ->label('Teilnahme'),
                Forms\Components\TextInput::make('evaluation')
                    ->label('Bewertung')
                    ->maxLength(1),
                Forms\Components\TextInput::make('year')
                    ->label('Jahr'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('address_id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('substance.textde')
                    ->sortable(),
                Tables\Columns\TextColumn::make('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('participation')
                    ->sortable(),
                Tables\Columns\TextColumn::make('evaluation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('Aktuelles Jahr')->query(
                    function (Builder $query): Builder {
                        //return $query->where('year',date("Y"));
                        return $query->where('year',date("Y"));
                    }
                ) ->label('Aktuelles Jahr'),

                Tables\Filters\Filter::make('Letztes_Jahr')->query(
                    function (Builder $query): Builder {
                        return $query->where('year',date("Y")-1);
                    }
                ) ->label('Letztes Jahr')->default(),

                Tables\Filters\Filter::make('Vorletztes_Jahr')->query(
                    function (Builder $query): Builder {
                        return $query->where('year',date("Y")-2);
                    }
                ) ->label('Vorletztes Jahr')
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
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}
