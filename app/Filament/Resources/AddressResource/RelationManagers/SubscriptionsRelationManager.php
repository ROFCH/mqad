<?php

namespace App\Filament\Resources\AddressResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\TextInputColumn;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'Subscriptions';
    protected static ?string $title = 'Bestellungen';

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Probe')
                    ->required()
                    ->preload()
                    ->relationship(
                        name:'product',
                        titleAttribute: 'code',
                        modifyQueryUsing: fn (Builder $query) => $query->where('sample',">",0)->orderBy('code'))
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->code} {$record->textde}"),
                Forms\Components\TextInput::make('sample_quantity')
                    ->label('Anzahl')
                    ->default(1),
                Forms\Components\TextInput::make('start_year')
                    ->default(date("Y"))
                    ->label('Beginn Jahr'),
                Forms\Components\TextInput::make('start_quarter')
                    ->label('Beginn Quartal')
                    ->default(1),
                Forms\Components\TextInput::make('stop_year')
                    ->label('End Jahr')
                    ->placeholder('Jahr')
                    ->default(0),
                Forms\Components\TextInput::make('stop_quarter')
                    ->label('End Quartal')
                    ->placeholder('Quartal')
                    ->default(0),        
                Forms\Components\Checkbox::make('free')
                    ->label('gratis'),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_id')
            ->defaultSort('product.code', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('product.code')
                    ->label('Id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.textde')
                    ->label('Probe'),
                Tables\Columns\TextColumn::make('sample_quantity')
                    ->label('Anzahl'),
                Tables\Columns\TextColumn::make('start_year')
                    ->label('Beginn Jahr'),
                Tables\Columns\TextColumn::make('start_quarter')
                ->label('Beginn Quartal'),
                Tables\Columns\TextInputColumn::make('stop_year')
                    ->label('End Jahr')
                    ->placeholder('Jahr'),
                Tables\Columns\TextInputColumn::make('stop_quarter')
                    ->label('End Quartal')
                    ->placeholder('Quartal'),
                Tables\Columns\CheckboxColumn::make('free')
                    ->label('gratis'),

            ])
            ->filters([
                Tables\Filters\Filter::make('Aktuelles Jahr')->query(
                    function (Builder $query): Builder {
                        //return $query->where('year',date("Y"));
                        return $query->where('stop_year',0)->orWhere('stop_year','>=',date("Y"))->orWhereNull('stop_year');
                    }
                ) ->label('Aktuelles Jahr')->default(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Neuer Eintrag')
                ->icon('heroicon-s-plus')
                ->modalHeading('Neue Bestellung'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->modalHeading('Bestellung bearbeiten'),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
