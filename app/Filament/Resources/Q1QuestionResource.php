<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Q1QuestionResource\Pages;
use App\Filament\Resources\Q1QuestionResource\RelationManagers;
use App\Models\Q1Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Q1QuestionResource extends Resource
{
    protected static ?string $model = Q1Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'Präanalytik Formular';

    protected static ?string $pluralModelLabel = 'Präanalytik Formular';
    protected static ?string $modelLabel = 'Präanalytik Formular';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(4)
            ->schema([


                Forms\Components\TextInput::make('id'),
                Forms\Components\TextInput::make('survey_id'),
                Forms\Components\TextInput::make('language_id'),
                Forms\Components\TextInput::make('entry_type_id'),
                Forms\Components\TextInput::make('question_nr'),

                Forms\Components\TextInput::make('evaluation')
                    ->columnstart(1),
                Forms\Components\TextInput::make('method_id'),
                Forms\Components\TextInput::make('menu_num'),
                Forms\Components\TextInput::make('translation_id'),


                Forms\Components\TextInput::make('position'),
                Forms\Components\TextInput::make('intro_text')
                    ->columnstart(1)
                    ->columnSpan(4),
                Forms\Components\FileUpload::make('intro_picture')
                    ->image()
                    ->imageEditor()
                    ->maxSize(1024 * 1024 * 10)
                    ->columnstart(1)
                    ->columnSpan(1),
                Forms\Components\TextInput::make('question')
                    ->columnstart(1)
                    ->columnSpan(4),
                Forms\Components\FileUpload::make('picture')
                    ->image()
                    ->imageEditor()
                    ->maxSize(1024 * 1024 * 10)
                    ->columnstart(1)
                    ->columnSpan(1),
                Forms\Components\TextInput::make('picture_txt')
                    ->columnstart(1)
                    ->columnSpan(4),
                Forms\Components\TextInput::make('answer_a')
                    ->columnstart(1)
                    ->columnSpan(4),
                Forms\Components\TextInput::make('answer_b')
                    ->columnstart(1)
                    ->columnSpan(4),
                Forms\Components\TextInput::make('answer_c')
                    ->columnstart(1)
                    ->columnSpan(4),
                Forms\Components\TextInput::make('answer_d')
                    ->columnstart(1)
                    ->columnSpan(4),

                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('survey_id')
                    ->label('Survey')
                    ->alignCenter(),    
                Tables\Columns\TextColumn::make('language_id')
                    ->label('Sprache')
                    ->alignCenter(),     
                Tables\Columns\TextColumn::make('entry_type_id')
                    ->label('Typ')
                    ->alignCenter(),     
                Tables\Columns\TextColumn::make('question_nr')
                    ->label('Frage Nr.')
                    ->alignCenter()
                    ->sortable(),     
                Tables\Columns\TextColumn::make('position')
                    ->label('Position')
                    ->alignCenter()
                    ->sortable(),          
                Tables\Columns\TextColumn::make('intro_text')
                    ->label('Intro Text')
                    
                    ->alignCenter(), 
                Tables\Columns\TextColumn::make('question')
                    ->label('Frage')
                    ->wrap(),
    
                    



            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Ringversuch')
                    ->relationship('survey','id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->year} - {$record->quarter} ({$record->id})")
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
            'index' => Pages\ListQ1Questions::route('/'),
            'create' => Pages\CreateQ1Question::route('/create'),
            'edit' => Pages\EditQ1Question::route('/{record}/edit'),
        ];
    }
}
