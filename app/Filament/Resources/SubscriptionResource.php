<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Subscription;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\SubscriptionExporter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Daten zur Adresse';
    protected static ?string $navigationLabel = 'Bestellungen';

    protected static ?string $pluralModelLabel = 'Bestellungen';
    protected static ?string $modelLabel = 'Bestellung';

    public static function form(Form $form): Form
    {
        return $form
        ->columns(2)
            ->schema([
                // Forms\Components\Select::make('address_id')
                //     ->relationship('address', 'name'),

                // Forms\Components\TextInput::make('address_id')
                //     ->label('Teilnehmernummer')
                //     ->readOnly()
                //     ->disabled(),
                Forms\Components\Select::make('address_id')
                ->label('Teilnehmernummer + Name')
                ->relationship(name: 'address', titleAttribute: 'id')
                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} - {$record->name}")
                ->disabled(),   
                Forms\Components\Select::make('product_id')
                    ->ColumnStart(1)
                    ->label('Probe')
                    ->required()
                    ->preload()
                    ->relationship(
                        name:'product',
                        titleAttribute: 'code',
                        modifyQueryUsing: fn (Builder $query) => $query->where('sample',">",0)->orderBy('code'))
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->code} {$record->textde}"),
                Forms\Components\TextInput::make('sample_quantity')
                    ->label('Anzahl'),
                //Forms\Components\DateTimePicker::make('inscription_date'),
                Forms\Components\TextInput::make('start_year')
                    ->default(date("Y"))
                    ->label('Beginn Jahr'),
                Forms\Components\TextInput::make('stop_year')
                    ->label('End Jahr'),    
                Forms\Components\TextInput::make('start_quarter')
                    ->label('Beginn Quartal'),
                //Forms\Components\DateTimePicker::make('termination_date'),

                Forms\Components\TextInput::make('stop_quarter')
                    ->label('End Quartal'),
                Forms\Components\Checkbox::make('free')
                    ->label('gratis')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('address_id')
                    ->label('Tnr')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address.name')
                    ->label('Teilnehmer')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.code')
                    ->label('Probe')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sample_quantity')
                    ->label('Anzahl')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('inscription_date')
                //     ->dateTime()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('start_year')
                    ->label('Beginn Jahr'),
                Tables\Columns\TextColumn::make('start_quarter')
                    ->label('Beginn Quartal'),
                // Tables\Columns\TextColumn::make('termination_date')
                //     ->dateTime()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('stop_year')
                     ->label('End Jahr'),
                Tables\Columns\TextColumn::make('stop_quarter')
                    ->label('End Quartal'),
                Tables\Columns\CheckboxColumn::make('free')
                    ->label('gratis'),
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
                ) ->label('Aktuelles Jahr')
                ->default(),



                SelectFilter::make('product_id')
                    ->label('Bestellte Probe')
                    //->relationship('product', 'id')
                    ->relationship('product', 'id', fn (Builder $query): Builder => $query->orderBy('code', 'asc'))
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->code} - {$record->textde} - ({$record->id}) ")
                    ->optionsLimit(1000),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->headerActions([
                ExportAction::make()->exporter(SubscriptionExporter::class)
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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
