<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use App\Filament\Exports\test;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Exports\ProductExporter;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\ProductExporter2;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen';
    protected static ?string $navigationLabel = 'Proben / Mitgliederbeiträge';

    protected static ?string $pluralModelLabel = 'Proben';
    protected static ?string $modelLabel = 'Probe';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(8)
            ->schema([
                Forms\Components\TextInput::make('textde')
                    ->columnSpan(2)
                    ->label('Bezeichnung')
                    ->maxLength(50)
                    ->required()
                    ->helperText('Interne Bezeichnung der Probe')
                    #->hint('Das ist ein Hint')
                    ->placeholder('Probenbezeichnung'),
                    //->HasHelperText("Das ist die deutsche Bezeichnung der Probe"),




                Forms\Components\TextInput::make('membership')
                    ->label('Bei Mitgliederbeitrag >0')
                    ->default(0)
                    ->helperText('Binär, gibt an welche Proben im Beitrag drin sind')
                    ->numeric(),    
                Forms\Components\TextInput::make('sample')
                    ->label('>0 = es ist eine Probe')
                    ->helperText('Ist die alte Probennummer. Nicht mehr verwenden')
                    ->numeric(),

                Forms\Components\TextInput::make('translation_id')
                    ->columnStart(1)
                    ->label('Übersetzungsnummer')
                    ->numeric(),


                Forms\Components\Select::make('translation_id')

                    ->columnSpan(5)
                    ->searchable()
                    ->label('Übersetzungen der Probenbezeichnung')
                    ->relationship('translation','de')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} :  {$record->de}   (fr: {$record->fr} -  it: {$record->it} -  en: {$record->en})")
                    ->helperText('Neue Einträge über Einstellungen->Übersetzungen machen '),  


                Forms\Components\TextInput::make('code')
                    ->columnStart(1)
                    ->label('Probenkürzel')
                    ->maxLength(4),
                Forms\Components\TextInput::make('sample_num')
                    ->label('Anzahl Proben')
                    ->default(1)
                    ->numeric(),





                Forms\Components\TextInput::make('price')
                    ->columnStart(1)
                    ->label('Preis')
                    ->prefix('CHF')
                    ->numeric(2),
                #Forms\Components\TextInput::make('sort')
                #    ->numeric(),


                Forms\Components\Select::make('delivery_note')
                    ->columnStart(1)
                    ->columnSpan(2)
                    ->searchable()
                    ->label('Bemerkung auf Lieferschein aus Übersetzungen')
                    ->relationship('translation','de')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} :  {$record->de}   (fr: {$record->fr} -  it: {$record->it} -  en: {$record->en})")
                    ->helperText('Neue Einträge über Einstellungen->Übersetzungen machen '),  

                Forms\Components\TextInput::make('delivery_note')
                    ->label('Bemerkung auf Lieferschein, Nummer')
                    ->numeric(),


                #Forms\Components\TextInput::make('packaging')
                #    ->numeric(),
                
                Forms\Components\Select::make('ship_format_id')
                    ->columnStart(1)
                    ->label('Minimal Versandformat')
                    ->default(1)
                    ->helperText('Das minimale Versandformat für diese Probe')
                    ->relationship('shipformat','textde'),
                Forms\Components\TextInput::make('ship_priority_id')
                    ->label('Versandpriortät')
                    ->helperText('1=normal, 4=erst am zweiten Tag')
                    ->numeric(),    
  
                Forms\Components\TextInput::make('type')
                    ->numeric(),
                Forms\Components\TextInput::make('sort2')
                    ->numeric(),
                Forms\Components\TextInput::make('evaluation')
                    ->numeric(),
                Forms\Components\TextInput::make('sort3')
                    ->numeric(),
                Forms\Components\TextInput::make('size')
                    ->numeric(),
                Forms\Components\TextInput::make('weight')
                    ->numeric(),
                Forms\Components\TextInput::make('translation_id')
                    ->numeric(),
                Forms\Components\TextInput::make('matrix')
                    ->maxLength(6),
                Forms\Components\TextInput::make('infectious')
                    ->numeric(),
                Forms\Components\Toggle::make('active')
                    ,
                Forms\Components\TextInput::make('volume')
                    ->maxLength(10),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('code', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('textde')
                    ->label('Deutsch (intern)')
                    ->searchable(),

                Tables\Columns\TextColumn::make('translation.de')
                    ->label('Deutsch')
                    ->searchable(),    
                Tables\Columns\TextColumn::make('sample')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('sample_num'),

                Tables\Columns\TextColumn::make('code')
                    ->label('Kürzel')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Preis')
                    ->numeric(2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('delivery_note')
                    ->label('Hinweis auf Lieferschein')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('packaging')
                    ->label('Verpackung')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ship_format_id')
                    ->label('Verpackungsformat')
                    ->numeric(),
                Tables\Columns\TextColumn::make('ship_priority_id')
                    ->label('Verpackungspriorität')
                    ->numeric(),


                Tables\Columns\TextColumn::make('membership')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sort2')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('evaluation')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sort3')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('size')
                    ->numeric()
                    ->sortable()
                    ->placeholder('test'),
                Tables\Columns\TextColumn::make('weight')
                    ->label('Gewicht')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('translation_id')
                    ->label('Übersetzung')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('matrix')
                    ->searchable(),
                Tables\Columns\TextColumn::make('infectious')
                    ->label('Infektiös')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('active')
                    ->label('Aktiv')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('volume')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->headerActions([
                //ExportAction::make()->exporter(ProductExporter::class),
                ExportAction::make()->exporter(test::class)
                    ->label('Excel: Proben + Teilnehmerzahlen'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
