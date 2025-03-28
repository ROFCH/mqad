<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Schedule;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ScheduleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ScheduleResource\RelationManagers;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Daten zur Adresse';
    protected static ?string $navigationLabel = 'Ersatz- und Spezialtermine';

    protected static ?string $pluralModelLabel = "Ersatz- und Spezialtermine";
    protected static ?string $modelLabel = 'Ersatz- und Spezialtermin';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('address_id')
                    ->label('Teilnehmer')
                    ->relationship('address', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} - {$record->name}")
                    ->disabled(),
                Forms\Components\Select::make('schedule_type_id')
                    ->label('Termintyp')
                    ->relationship('schedule_type', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} - {$record->textde}"),
                Forms\Components\TextInput::make('year')
                    ->label('Jahr'),
                Forms\Components\TextInput::make('quarter')
                    ->label('Quartal'),
                Forms\Components\TextInput::make('remark')
                    ->maxLength(100),
                Forms\Components\TextInput::make('survey_id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('schedule_type.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quarter')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remark')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('survey_id')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
