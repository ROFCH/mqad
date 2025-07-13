<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Code;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CodeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CodeResource\RelationManagers;

class CodeResource extends Resource
{
    protected static ?string $model = Code::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'Codes';

    protected static ?string $pluralModelLabel = 'Codes';
    protected static ?string $modelLabel = 'Code';


    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->join('products', 'codes.product_id', '=', 'products.id')
    //         ->select('codes.*')
    //         ->orderBy('products.code');
    // }



    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->numeric()
                    ,
                Forms\Components\TextInput::make('sort')
                    ->label('Reihenfolge')
                    ->numeric(),

                Forms\Components\TextInput::make('textde')
                    ->label('Bezeichnung')
                    ->columnStart(1)
                    ->maxLength(100),


                Forms\Components\Select::make('product_id')
                    ->columnStart(1)
                    ->label('Ringversuch')
                    ->default(56)
                    ->relationship('product','textde'),
                // Forms\Components\TextInput::make('translation_id')
                //     ->columnStart(1),   
                Forms\Components\Select::make('translation_id')
                    ->columnStart(1)
                    ->label('Übersetzung')
                    ->default(200)
                    ->searchable()
                    ->relationship('translation','de'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            //->defaultSort('product.code', 'asc')
            // ->defaultSort(function (Builder $query): Builder {
            //     return $query
            //         ->orderBy('product.code')
            //         ->orderBy('code.sort');
            //     })
            


            ->columns([
                Tables\Columns\TextColumn::make('product.code')
                    ->label('RV')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('code'),
                Tables\Columns\TextColumn::make('textde')
                    ->label('Bezeichnung')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort')
                    ->numeric()
                    ->sortable()
                    ,
                Tables\Columns\TextColumn::make('translation_id')
                    ->label('Übersetzung'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort')
            ->filters([
                   
                SelectFilter::make('product_id')
                    ->label('Produkt')
                    ->options(
                        Product::query()
                            ->whereIn('id', function ($query) {
                                $query->select('product_id')
                                    ->from('codes')
                                    ->whereNotNull('product_id'); // optional, falls nullable
                            })
                            ->orderBy('code')
                            ->get()
                            ->mapWithKeys(function ($product) {
                                return [$product->id => "{$product->code} ({$product->id})"];
                            })
                    )
                    ->searchable()
                    ->placeholder('Alle Produkte')
       
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
            'index' => Pages\ListCodes::route('/'),
            'create' => Pages\CreateCode::route('/create'),
            'edit' => Pages\EditCode::route('/{record}/edit'),
        ];
    }
}
