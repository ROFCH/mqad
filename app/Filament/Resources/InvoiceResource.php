<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Invoice;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\InvoiceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InvoiceResource\RelationManagers;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Daten zur Adresse';
    protected static ?string $navigationLabel = 'Rechnungen';

    protected static ?string $pluralModelLabel = 'Rechnungen';
    protected static ?string $modelLabel = 'Rechnung';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('address_id')
                //     ->relationship('address', 'name'),
                Forms\Components\DatePicker::make('booking')
                ->date('Y-m-d')
                ->label('Buchungsdatum'),

            Forms\Components\Select::make('product_id')
                ->label('Buchung')
                ->preload()
                ->relationship(
                    name:'product',
                    titleAttribute: 'id',
                    modifyQueryUsing: fn (Builder $query) => $query->orderBy('code','asc')
                    )
                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->code} {$record->textde} {$record->id}"),

                
            Forms\Components\TextInput::make('debit')
                    ->label('Soll')
                ->numeric(),
            Forms\Components\TextInput::make('credit')
                    ->label('Haben')
                ->numeric(),
            Forms\Components\TextInput::make('amount')
                    ->label('Betrag')
                ->numeric(),
            Forms\Components\TextInput::make('invoice_number')
                    ->label('Rechnungsnummer')
                ->numeric(),
            Forms\Components\TextInput::make('quantity')
                    ->label('Menge')
                ->numeric(),
            Forms\Components\TextInput::make('year')
                    ->label('Jahr')
                ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('address.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking')
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.code')
                    ->sortable(),
                Tables\Columns\TextColumn::make('debit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('credit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->paginated()
            ->paginationPageOptions([10, 25, 50])

            ->filters([
                Tables\Filters\Filter::make('Standard Jahr')->query(
                    function (Builder $query): Builder {
                        //return $query->where('year',date("Y"));
                        //fn()=>auth()->user()->year
                        return $query->where('year',config('app.year'));
                        //return $query->where('year',fn()=>auth()->user()->year);
                    }
                ) ->label(config('app.year'))->default(),

                Tables\Filters\Filter::make('Letztes_Jahr')->query(
                    function (Builder $query): Builder {
                        return $query->where('year',date("Y")-1);
                    }
                ) ->label('Letztes Jahr'),

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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
