<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportTypeResource\Pages;
use App\Filament\Resources\ReportTypeResource\RelationManagers;
use App\Models\ReportType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportTypeResource extends Resource
{
    protected static ?string $model = ReportType::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen';
    protected static ?string $navigationLabel = 'Resultateversand-Gruppen';

    protected static ?string $pluralModelLabel = 'Resultateversand-Gruppen';
    protected static ?string $modelLabel = 'Resultateversand-Gruppe';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('textde')
                    ->maxLength(50),
                Forms\Components\TextInput::make('remarks')
                    ->maxLength(200),
                Forms\Components\TextInput::make('translation_id')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('textde')
                    ->searchable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->searchable(),
                Tables\Columns\TextColumn::make('translation_id')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListReportTypes::route('/'),
            'create' => Pages\CreateReportType::route('/create'),
            'edit' => Pages\EditReportType::route('/{record}/edit'),
        ];
    }
}
