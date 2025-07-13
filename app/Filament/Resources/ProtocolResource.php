<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Protocol;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\ProtocolExporter;
use App\Filament\Resources\ProtocolResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProtocolResource\RelationManagers;

class ProtocolResource extends Resource
{
    protected static ?string $model = Protocol::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Daten zur Adresse';
    protected static ?string $navigationLabel = 'Protokolle';

    protected static ?string $pluralModelLabel = 'Protokolle';
    protected static ?string $modelLabel = 'Protokoll';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('address_id')
                //     ->relationship('address', 'name')
                //     ->default(1),
                Forms\Components\Select::make('method_id')
                    ->relationship('method', 'id')
                    ->default(1),
                Forms\Components\Select::make('unit_id')
                    ->relationship('unit', 'id')
                    ->default(1),
                Forms\Components\TextInput::make('device_id')
                    ->numeric(),
                Forms\Components\TextInput::make('device_num')
                    ->maxLength(10),
                Forms\Components\TextInput::make('Serialnumber')
                    ->maxLength(10),
                Forms\Components\TextInput::make('department')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('start_date'),
                Forms\Components\TextInput::make('start_year')
                    ->numeric(),
                Forms\Components\TextInput::make('start_quarter')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('stop_date'),
                Forms\Components\TextInput::make('stop_year')
                    ->numeric(),
                Forms\Components\TextInput::make('stop_quarter')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('address_id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('method.number')
                    ->sortable()
                    ->searchable(),    
                Tables\Columns\TextColumn::make('method.substance.textde')
                    ->sortable(),
                Tables\Columns\TextColumn::make('method.instrument.textde')
                    ->sortable(),    
                Tables\Columns\TextColumn::make('unit.unitSymbol.textde'),
                Tables\Columns\TextColumn::make('device.textde'),
                Tables\Columns\TextColumn::make('device_num')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('Serialnumber')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('department')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('start_date')
                //     ->date('Y-m-d')
                //     ->sortable(),
                Tables\Columns\TextColumn::make('start_quarter')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_year')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('stop_date')
                //     ->date('Y-m-d')
                //     ->sortable(),
                Tables\Columns\TextColumn::make('stop_year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stop_quarter')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->paginated()
            ->paginationPageOptions([10, 25, 50])


            ->filters([
                Tables\Filters\Filter::make('Aktuelles Jahr')->query(
                    function (Builder $query): Builder {
                        //return $query->where('year',date("Y"));
                        return $query->where('stop_year',0)->orWhere('stop_year','>=',date("Y"));
                    }
                ) ->label('Aktuelles Jahr')->default(),

                Tables\Filters\Filter::make('Letztes_Jahr')->query(
                    function (Builder $query): Builder {
                        return $query->where('stop_year',date("Y")-1);
                    }
                ) ->label('Letztes Jahr'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->headerActions([
                ExportAction::make()->exporter(ProtocolExporter::class)
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
            'index' => Pages\ListProtocols::route('/'),
            'create' => Pages\CreateProtocol::route('/create'),
            'edit' => Pages\EditProtocol::route('/{record}/edit'),
        ];
    }
}
