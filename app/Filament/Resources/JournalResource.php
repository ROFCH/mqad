<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use App\Models\Journal;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\JournalResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JournalResource\RelationManagers;

class JournalResource extends Resource
{
    protected static ?string $model = Journal::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Daten zur Adresse';
    protected static ?string $navigationLabel = 'Ereignisse';

    protected static ?string $pluralModelLabel = 'Ereignisse';
    protected static ?string $modelLabel = 'Ereignis';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(8)
            ->schema([
                Forms\Components\TextInput::make('survey_id')
                ->label('Ringversuch')
                    ->numeric(),
                Forms\Components\TextInput::make('quarter')
                    ->label('Quartal')
                    ->numeric(),
                Forms\Components\TextInput::make('year')
                    ->label('Jahr')
                    ->numeric(),
                Forms\Components\Select::make('address_id')
                    ->label('Teilnehmer')
                    ->relationship('address', 'name')
                    ->columnStart(1)
                    ->columnSpan(2),
                Forms\Components\Select::make('journal_type_id')
                    ->label('Eintragtyp')
                    ->columnStart(1)
                    ->relationship('journaltype', 'textde'),
                // Forms\Components\TextInput::make('journal_type_id'),    
                Forms\Components\TextInput::make('sample')
                ->label('Probenbezeichnungen')
                    ->columnStart(1)
                    ->columnSpan(4)
                    ->maxLength(50),
                Forms\Components\TextInput::make('remark')
                    ->label('Bemerkungen')
                    ->columnStart(1)
                    ->columnSpan(4)
                    ->maxLength(50),

                Forms\Components\TextInput::make('user')
                    ->label('Benutzerkürzel')
                    ->columnStart(1)
                    ->maxLength(10),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('address_id'),
                Tables\Columns\TextColumn::make('address.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('journaltype.textde')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sample')
                    ->searchable(),
                Tables\Columns\TextColumn::make('remark')
                    ->label('Bemerkungen')
                    ->searchable(),

                Tables\Columns\TextColumn::make('quarter')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->label('Jahr')
                    
                    ->sortable(),
                Tables\Columns\TextColumn::make('survey_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            ->defaultSort('address_id', 'asc')
            
            ->filters([
                                Tables\Filters\SelectFilter::make('survey_id')
                        ->label('Ringversuch')
                        ->options(
                            Survey::all()->mapWithKeys(function ($survey) {
                                return [
                                    $survey->id => "{$survey->year} / Q{$survey->quarter}",
                                ];
                            })
                        )
                        ->default(Survey::where('def_survey', true)->value('id'))
                        ->searchable(),
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
            'index' => Pages\ListJournals::route('/'),
            'create' => Pages\CreateJournal::route('/create'),
            'edit' => Pages\EditJournal::route('/{record}/edit'),
        ];
    }
}
