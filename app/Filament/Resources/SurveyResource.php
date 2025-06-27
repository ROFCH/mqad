<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyResource\Pages;
use App\Filament\Resources\SurveyResource\RelationManagers;
use App\Models\Survey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Ringversuchstermine';

    protected static ?string $pluralModelLabel = 'Ringversuchstermine';
    protected static ?string $modelLabel = 'Ringversuchstermin';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(5)
            ->schema([
                Forms\Components\TextInput::make('quarter')
                    ->label('Quartal')
                    ->numeric(),
                Forms\Components\TextInput::make('year')
                    ->label('Jahr')
                    ->numeric(),

                Forms\Components\DatePicker::make('shipping')
                    ->columnstart(1)
                    ->label('Versand'),
                Forms\Components\DatePicker::make('closing')
                    ->label('Einsendeschluss'),
                Forms\Components\DatePicker::make('replacementdate')
                    ->label('Ersatztermin'),
                Forms\Components\DatePicker::make('end')
                    ->label('Abschluss'),
                Forms\Components\TextInput::make('status')
                ->columnstart(1)
                    ->numeric(),
                Forms\Components\TextInput::make('remark')
                    ->maxLength(50),
                Forms\Components\TextInput::make('online_id')
                    ->numeric(),
                Forms\Components\TextInput::make('remark')
                    ->columnspan(2)
                    ->maxLength(50),
                Forms\Components\TextInput::make('def_survey')
                    ->columnStart(1)
                    ->numeric(),    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([

                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('year')
                    ->label('Jahr')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quarter')
                    ->label('Quartal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipping')
                    ->label('Versand')
                    ->date('D d.m.Y') ,
                Tables\Columns\TextColumn::make('closing')
                    ->label('Einsendeschluss')
                    ->date('D d.m.Y') ,
                Tables\Columns\TextColumn::make('replacementdate')
                    ->label('Ersatztermin')
                    ->date('D d.m.Y') ,
                    Tables\Columns\TextColumn::make('reminder')
                    ->label('Nach Mahnung')
                    ->date('D d.m.Y') ,    
                Tables\Columns\TextColumn::make('end')
                ->date('D d.m.Y') ,
                Tables\Columns\TextColumn::make('status')
                    ->sortable(),
                Tables\Columns\CheckboxColumn::make('regular')
                    ->sortable(),    
                Tables\Columns\CheckboxColumn::make('def_survey')
                    ->sortable(),        
                Tables\Columns\TextColumn::make('remarks')
                    ->searchable(),
                Tables\Columns\TextColumn::make('online_id')
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
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
        ];
    }
}
