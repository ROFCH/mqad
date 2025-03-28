<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ActivityLog;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\KeyValueEntry;
use AhmedAbdelaal\FilamentJsonPreview\JsonPreview;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ActivityLogResource\Pages;
use App\Filament\Resources\ActivityLogResource\RelationManagers;



class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Verwaltung';
    protected static ?string $navigationLabel = 'Datenbank Überwachung';

    protected static ?string $pluralModelLabel = 'Datenbank Überwachung';
    protected static ?string $modelLabel = 'Datenbank Überwachung';

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('id'),
                // Tables\Columns\TextColumn::make('log_name')
                //     ->label('Log_name'),   
                Tables\Columns\TextColumn::make('description')
                    ->label('Beschreibung'),
                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Tabelle'),   
                // Tables\Columns\TextColumn::make('event')
                //     ->label('Ereignis'),
                Tables\Columns\TextColumn::make('subject_id')
                    ->label('TabellenID'),   
                //Tables\Columns\TextColumn::make('causer_type')
                //    ->label('Benutzer'),
                // Tables\Columns\TextColumn::make('causer_id')
                //     ->label('BenutzerID'), 
                    Tables\Columns\TextColumn::make('user.name')
                    ->label('Benutzer Name'), 
                        
                Tables\Columns\TextColumn::make('properties')
                    ->label('Geändert')
                    ->limit(50),
            //         ->extraAttributes([
            //     'style' => 'max-width:260px'
            // ]),  
                Tables\Columns\TextColumn::make('batch_uuid')
                    ->label('id'),   
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Datum+Zeit'),       
            ])

           

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Detail')
                    ->infolist([
                        KeyValueEntry::make('properties.attributes')
                        ->label('New Value')
                        ->columnSpan(2),
                    KeyValueEntry::make('properties.old')
                        ->label('Old Value')
                        ->visible(fn (ActivityLog $record) => $record->properties->has('old'))
                        ->columnSpan(2),
  
                        //TextEntry::make((json_decode('properties',true))),


                        ])



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
            'index' => Pages\ListActivityLogs::route('/'),
            'create' => Pages\CreateActivityLog::route('/create'),
            'edit' => Pages\EditActivityLog::route('/{record}/edit'),
        ];
    }
}
