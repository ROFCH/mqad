<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Substance;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\SubstanceExporter;
use App\Filament\Resources\SubstanceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubstanceResource\RelationManagers;

class SubstanceResource extends Resource
{
    protected static ?string $model = Substance::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Einstellungen Resultate';
    protected static ?string $navigationLabel = 'Substanzen';

    protected static ?string $pluralModelLabel = 'Substanzen';
    protected static ?string $modelLabel = 'Substanz';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->disabled(),
                Forms\Components\TextInput::make('textde')
                    ->label('Substanz')
                    ->columnStart(1)
                    ->maxLength(30),
                // Forms\Components\TextInput::make('unitsi')
                //     ->numeric(),
                // Forms\Components\TextInput::make('unitold')
                //     ->numeric(),
                // Forms\Components\TextInput::make('conversion')
                //     ->numeric(),
                // Forms\Components\TextInput::make('decimalsi')
                //     ->numeric(),
                // Forms\Components\TextInput::make('decimalold')
                //     ->numeric(),

                // Forms\Components\TextInput::make('type')
                //     ->numeric(),

                Forms\Components\Select::make('product_id')
                    ->columnStart(1)
                    ->preload()
                    ->label('Probe')
                    ->relationship('product','product_id', 
                        modifyQueryUsing: fn (Builder $query) => $query->where('sample',">",0)->orderBy('code'))
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->code} {$record->textde}")
                    ->searchable()
                    ->optionsLimit(10000),
                Forms\Components\TextInput::make('sort')
                    ->label('Reihenfolge innerhalb der Probe')
                    ->helperText('Die anderen Nummern dieser Probe vorher anschauen')
                    ->default(1)
                    ->numeric(),
                Forms\Components\TextInput::make('qualab_id')
                    ->numeric(),
                Forms\Components\Select::make('eval_type_id')
                    ->label('Typ Auswertung')
                    ->relationship('evalType','textde'),
            
                Fieldset::make('Toleranzen')
                    ->schema([
                        Forms\Components\TextInput::make('tolerance')
                            ->label('QUALAB oder MQ Toleranz in % (=relative Toleranz)')
                            ->default(0)
                            ->numeric(),
                Forms\Components\TextInput::make('limit1')
                    ->label('Untere Grenze für absolute Toleranz in der Standard/SI Einheit')
                    ->columnStart(1)
                    ->default(0)
                    ->numeric(),
                // Forms\Components\TextInput::make('limit2')
                //     ->numeric(),
                Forms\Components\TextInput::make('toleranceabs')
                    ->label('Absolute Toleranz in der Standard/SI Einheit')
                    ->default(0)
                    ->numeric(),
                    ]),  

                Forms\Components\TextInput::make('ealn')
                    ->numeric(),
                Forms\Components\TextInput::make('ealn_subcode')
                    ->numeric(),
                Forms\Components\Checkbox::make('publish')
                    ->default(true)
                    ->label("Die Substanz wird auf dem Web publiziert")
                    ->inline()                    
                    ->columnStart(1),
                Forms\Components\Checkbox::make('zero')
                    ->label("Resultat darf Null sein")
                    ->default(true)
                    ->inline(),      
                Forms\Components\TextInput::make('translation_id')
                    ->label('Übersetzungs ID')
                    ->columnstart(1),   
                Forms\Components\Select::make('translation_id')
                    ->columnstart(1)
                    ->columnSpan(5)
                    ->searchable()
                    ->label('Übersetzungen der Substanz')
                    ->relationship('translation','de')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} :  {$record->de}   (fr: {$record->fr} -  it: {$record->it} -  en: {$record->en})")
                    ->helperText('Neue Einträge über Einstellungen->Übersetzungen machen '),             
                Forms\Components\TextInput::make('remark')
                    ->columnspan(2)
                    ->maxLength(20),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('textde')
                    ->label('Substanz (intern)')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                    Tables\Columns\TextColumn::make('translation.de')
                    ->label('Substanz Deutsch')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                    Tables\Columns\TextColumn::make('translation.fr')
                    ->label('Substanz Französisch')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('translation.it')
                    ->label('Substanz Italienisch')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('translation.en')
                    ->label('Substanz Englisch')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('unitsi')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('unitold')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('conversion')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('decimalsi')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('decimalold')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('tolerance')
                    ->label('Toleranz%')
                    ->numeric()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('type')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.code')
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('qualab_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('evaltype.textde')
                    ->label('Typ Auswertung')
                    ->sortable(),
                Tables\Columns\TextColumn::make('limit1')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('limit2')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('toleranceabs')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ealn')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ealn_subcode')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('publish')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remark')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zero')
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

            ->headerActions([
                ExportAction::make()->exporter(SubstanceExporter::class)
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
            RelationManagers\UnitsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubstances::route('/'),
            'create' => Pages\CreateSubstance::route('/create'),
            'edit' => Pages\EditSubstance::route('/{record}/edit'),
        ];
    }
}
