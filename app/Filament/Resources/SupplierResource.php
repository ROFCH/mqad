<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Verwaltung';
    protected static ?string $navigationLabel = 'Lierferanten';

    protected static ?string $pluralModelLabel = 'Lieferanten';
    protected static ?string $modelLabel = 'Lieferant';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Name')
                    ->maxLength(100),
                Forms\Components\TextInput::make('address1')
                    ->maxLength(100),
                Forms\Components\TextInput::make('address2')
                    ->maxLength(100),
                Forms\Components\TextInput::make('postalcode')
                    ->maxLength(20),
                Forms\Components\TextInput::make('city')
                    ->maxLength(100),
                Forms\Components\TextInput::make('country')
                    ->maxLength(50),
                Forms\Components\TextInput::make('web')
                    ->maxLength(100),
                Forms\Components\TextInput::make('certification')
                    ->maxLength(100),
                Forms\Components\TextInput::make('sup_since')
                    ->numeric(),
                Forms\Components\TextInput::make('staff')
                    ->maxLength(1000),
                Forms\Components\TextInput::make('order_mail')
                    ->maxLength(1000),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postalcode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('web')
                    ->searchable(),
                Tables\Columns\TextColumn::make('certification')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sup_since')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('staff')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_mail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
