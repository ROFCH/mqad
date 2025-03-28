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
            ->schema([
                Forms\Components\TextInput::make('textde')
                    ->label('Bezeichnung')
                    ->maxLength(50)
                    ->required()
                    ->helperText('Das ist die deutsche Bezeichnung der Probe')
                    ->hint('Das ist ein Hint')
                    ->placeholder('Hallo Placeholder'),
                    //->HasHelperText("Das ist die deutsche Bezeichnung der Probe"),
                Forms\Components\TextInput::make('sample')
                    ->label('>0 = es ist eine Probe')
                    ->numeric(),
                Forms\Components\TextInput::make('sample_num')
                    ->label('Anzahl Proben'),
                Forms\Components\TextInput::make('code')
                    ->label('Probenkürzel')
                    ->maxLength(4),
                Forms\Components\TextInput::make('price')
                    ->label('Preis')
                    ->prefix('CHF')
                    ->numeric(2),
                Forms\Components\TextInput::make('sort')
                    ->numeric(),
                Forms\Components\TextInput::make('delivery_note')
                    ->numeric(),
                Forms\Components\TextInput::make('packaging')
                    ->numeric(),
                Forms\Components\TextInput::make('membership')
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
