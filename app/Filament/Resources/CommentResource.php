<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use App\Models\Comment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CommentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CommentResource\RelationManagers;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'Kommentare zu Proben';

    protected static ?string $pluralModelLabel = 'Kommentare zu Proben';
    protected static ?string $modelLabel = 'Kommentare zu Probe';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(4)
            ->schema([
                Forms\Components\Select::make('survey_id')
                    ->relationship('survey', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->quarter} - {$record->year} ({$record->id})"),
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->code} ({$record->id})"),
                Forms\Components\TextInput::make('sample')
                    ->numeric(),
                Forms\Components\TextInput::make('type')
                    ->numeric(),    
                Forms\Components\TextInput::make('textch')
                    ->label('Titel')
                    ->columnStart(1),
                Forms\Components\Textarea::make('de')
                    ->label('Beschreibung DE')
                    ->columnStart(1)
                    ->columnSpan('full')
                    ->rows(4),
                    Forms\Components\Textarea::make('fr')
                    ->label('Beschreibung FR')
                    ->columnStart(1)
                    ->columnSpan('full')
                    ->rows(4),
                    Forms\Components\Textarea::make('it')
                    ->label('Beschreibung IT')
                    ->columnStart(1)
                    ->columnSpan('full')
                    ->rows(4),
                    Forms\Components\Textarea::make('en')
                    ->label('Beschreibung EN')
                    ->columnStart(1)
                    ->columnSpan('full')
                    ->rows(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

        ->defaultSort(function (Builder $query): Builder {
            return $query
                ->orderBy('survey_id','desc')
                ->orderBy('textch','asc');
        })

            ->columns([
                Tables\Columns\TextColumn::make('survey.id')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('survey.quarter')
                        ->label('Quartal')
                        ->alignCenter(),
                    Tables\Columns\TextColumn::make('survey.year') 
                        ->label('Jahr')
                        ->alignCenter(),   
                // Tables\Columns\TextColumn::make('product.id')
                //     ->numeric()
                //     ->sortable(),
                    Tables\Columns\TextColumn::make('product.code')
                        ->label('RvID')
                        ->alignCenter(),    
                Tables\Columns\TextColumn::make('sample')
                    ->label('Probe')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('textch')
                    ->label('Titel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('de')
                    ->label('Text')
                    ->searchable()
                    ->wrap(),
                // Tables\Columns\TextColumn::make('fr')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('it')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('en')
                //     ->searchable(),
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
                        ,
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
