<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use App\Models\Schedule;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\ScheduleExporter;
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
        
        $currentSurvey = Survey::where('status', 1)->orderByDesc('id')->first();
        
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
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} - {$record->textde}")
                    ->default(2),
                Forms\Components\TextInput::make('year')
                    ->label('Jahr')
                    ->default($currentSurvey?->year),
                Forms\Components\TextInput::make('quarter')
                    ->label('Quartal')
                    ->default($currentSurvey?->quarter),
                Forms\Components\TextInput::make('remark')
                    ->maxLength(100),
                Forms\Components\TextInput::make('survey_id')
                    ->default($currentSurvey?->id),
            ]);
    }

    public static function table(Table $table): Table
    {
        
       
        
        
        return $table

            ->defaultSort('address_id')

            ->columns([


                Tables\Columns\TextColumn::make('survey_id')
                    ->label('Ringversuch')
                    ->sortable(),

                Tables\Columns\TextColumn::make('quarter')
                    
                    ->label('Quartal'),


                Tables\Columns\TextColumn::make('year')
                    
                    ->label('Jahr'),

                Tables\Columns\TextColumn::make('address.id')
                    ->label('Teilnehmernummer')
                    ->sortable()
                    ->searchable(),



                Tables\Columns\TextColumn::make('address.name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('address.postal_code')
                    ->label('Postleitzahl')
                    ->sortable(),    

                Tables\Columns\TextColumn::make('address.city')
                    ->label('City')
                    ->sortable(),

                Tables\Columns\TextColumn::make('schedule_type.textde')
                    ->label('Termintyp')
                    ->sortable(),

                Tables\Columns\TextColumn::make('remark')
                    ->label('Bemerkungen')
                    ->searchable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_by')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


            ])
            ->filters([
                SelectFilter::make('survey_id')

                ->label('Ringversuch')
                ->options(fn () => 
                    Survey::where('status', 1)
                        ->orderByDesc('id')
                        ->get()
                        ->mapWithKeys(fn ($survey) => [
                            $survey->id => "Q{$survey->quarter} - {$survey->year} (ID: {$survey->id})",
                        ])
                )
                ->default(fn () => 
                    Survey::where('status', 1)
                        ->orderByDesc('id')
                        ->value('id')
                )
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])


            ->headerActions([
                ExportAction::make()
                    ->exporter(ScheduleExporter::class),
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
