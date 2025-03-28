<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComplaintResource\Pages;
use App\Filament\Resources\ComplaintResource\RelationManagers;
use App\Models\Complaint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Verwaltung';
    protected static ?string $navigationLabel = 'Reklamationen';

    protected static ?string $pluralModelLabel = 'Reklamationen';
    protected static ?string $modelLabel = 'Reklamation';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('address_id')
                    ->relationship('address', 'name'),
                Forms\Components\TextInput::make('type')
                    ->maxLength(50),
                Forms\Components\TextInput::make('name')
                    ->maxLength(50),
                Forms\Components\TextInput::make('title')
                    ->maxLength(50),
                Forms\Components\TextInput::make('problem')
                    ->maxLength(1000),
                Forms\Components\TextInput::make('measures')
                    ->maxLength(1000),
                Forms\Components\TextInput::make('feedback')
                    ->maxLength(1000),
                Forms\Components\TextInput::make('closed')
                    ->numeric(),
                Forms\Components\DatePicker::make('date'),
                Forms\Components\TextInput::make('user')
                    ->maxLength(50),
                Forms\Components\TextInput::make('suggestion')
                    ->maxLength(1000),
                Forms\Components\TextInput::make('cause')
                    ->maxLength(1000),
                Forms\Components\TextInput::make('impact')
                    ->maxLength(1000),
                Forms\Components\TextInput::make('damage')
                    ->maxLength(1000),
                Forms\Components\TextInput::make('correction')
                    ->maxLength(1000),
                Forms\Components\DatePicker::make('date_qm'),
                Forms\Components\TextInput::make('user_qm')
                    ->maxLength(50),
                Forms\Components\TextInput::make('closed_qm')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('address.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('problem')
                    ->searchable(),
                Tables\Columns\TextColumn::make('measures')
                    ->searchable(),
                Tables\Columns\TextColumn::make('feedback')
                    ->searchable(),
                Tables\Columns\TextColumn::make('closed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user')
                    ->searchable(),
                Tables\Columns\TextColumn::make('suggestion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cause')
                    ->searchable(),
                Tables\Columns\TextColumn::make('impact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('damage')
                    ->searchable(),
                Tables\Columns\TextColumn::make('correction')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_qm')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_qm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('closed_qm')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListComplaints::route('/'),
            'create' => Pages\CreateComplaint::route('/create'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}
