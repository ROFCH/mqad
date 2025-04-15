<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Address;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Fieldset;
use App\Filament\Exports\AddressExporter;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AddressResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AddressResource\RelationManagers;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Adressen';

    protected static ?string $pluralModelLabel = 'Adressen';
    protected static ?string $modelLabel = 'Adresse';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([

                Tabs::make('Tabs')
                ->columnSpanFull()
                ->tabs([
                    Tabs\Tab::make('Basis')
                        ->columns(columns: 4)
                        ->schema([ 
                    Forms\Components\TextInput::make('id')
                        ->disabled()
                        ->maxLength(80),                       
                    Forms\Components\TextInput::make('salutation')
                        ->label('Anrede')
                        ->maxLength(80),
                    Forms\Components\TextInput::make('name')
                        ->columnSpan(4)
                        ->maxLength(80),
                    Forms\Components\TextInput::make('address')
                        ->label('Zusatz zum Namen')
                        ->columnSpan(4)
                        ->maxLength(80),
                    Forms\Components\TextInput::make('address2')
                        ->label('Adresse Strasse + Nummer')
                        ->columnSpan(4)
                        ->maxLength(80),
                    Forms\Components\TextInput::make('country')
                        ->label('Land')
                        ->default('CH')
                        ->maxLength(10), 
                    Forms\Components\TextInput::make('postal_code')
                        ->label('Postleitzahl')
                        ->maxLength(20),
                    Forms\Components\TextInput::make('city')
                        ->label('Stadt')
                        ->columnSpan(2)
                        ->maxLength(80),
                Forms\Components\TextInput::make('phone')
                            ->label('Telefon')
                    ->tel()
                    ->maxLength(20),
                Forms\Components\TextInput::make('mail')
                            ->label('E-Mail')
                    ->maxLength(80),
                Forms\Components\TextInput::make('contact')
                            ->label('Kontaktperson')
                    ->columnSpan(2)
                    ->maxLength(50),
                Forms\Components\TextInput::make('remarks')
                            ->label('Bemerkungen')
                    ->columnSpan(4)
                    ->maxLength(200),
                    ]),
                Tabs\Tab::make('Einstellungen')
                    ->columns(columns: 4)
                    ->schema([ 

                        Fieldset::make('Adresse')
                            ->columns(4)
                            ->schema([

                                Forms\Components\Select::make('language_id')
                                    ->label('Sprache des Teilnehmers')
                                    ->default(1)
                                    ->relationship('language', 'textde'),

                                    
                                Forms\Components\Select::make('status_id')
                                    ->default(1)
                                    ->relationship('status', 'textde'),      
                                Forms\Components\Select::make('lab_type_id')
                                    ->label('Labortyp')
                                    ->default(2)
                                    ->relationship('labType', 'textde'),
                                Forms\Components\Select::make('lab_group_id')
                                    ->label('Laborgruppe')
                                    ->relationship('labGroup', 'textde')
                                    ->nullable(),
                                Forms\Components\Checkbox::make('qualab')
                                    ->default(false)
                                    ->inline(),

  
                            ]),
                        Fieldset::make('Probenversand/Protokoll')
                            ->columns(4)
                            ->schema([

                                Forms\Components\Select::make('ship_type_id')
                                    ->label('Protokollversand')
                                    ->default(1)
                                    ->relationship('shipType', 'textde'),

                                Forms\Components\Select::make('ship_format_id')
                                    ->label('Versandformat')
                                    ->default(1)
                                    ->relationship('shipFormat', 'textde'),


                                Forms\Components\Checkbox::make('difficult')
                                    ->label('Nicht extern erfassen')
                                    ->default(false)
                                    ->inline(),
                            ]),    

                        Fieldset::make('Auswertungen/Resultate')
                            ->columns(4)
                            ->schema([
                                Forms\Components\Select::make('report_type_id')
                                    ->label('Resultateversand-Gruppe')
                                    ->default(1)                              
                                    ->relationship('reportType', 'textde'),
                                Forms\Components\Select::make('report_format_id')
                                    ->label('Resultateversand-Typ')
                                    ->default(2)     
                                    ->relationship('reportFormat', 'textde'),   
                                Forms\Components\Checkbox::make('no_reminder')
                                    ->label('Keine Mahnung')
                                    ->default(false)   
                                    ->inline(),
                                Forms\Components\Checkbox::make('temp_no_reminder')
                                    ->label('Temporär keine Mahnung')
                                    ->default(false)   
                                    ->inLine(),    
                                Forms\Components\Checkbox::make('h3_education_only')
                                    ->label('H3 nur für Weiterbilung')
                                    ->default(false)  
                                    ->inline(),   
                                Forms\Components\Checkbox::make('report_multi_device')
                                    ->label('Mit Risikoabschätzung bei mehreren Geräten')
                                    ->default(false)  
                                    ->inline(),     
                                Forms\Components\TextInput::make('report_size_id')
                                    ->label('Layout für Auswertungen')
                                    ->default(1)  
                                    ->numeric(),      

                            ]),  
                                

                       




                    Forms\Components\TextInput::make('default_password')
                        ->columnspan(1)
                        ->maxLength(10),
                    Forms\Components\TextInput::make('online_num')
                        ->numeric(),



                    Forms\Components\TextInput::make('qualab_num')
                        ->columnSpan(1)
                        ->maxLength(13),
                    Forms\Components\TextInput::make('sas_num')
                        ->columnSpan(1)
                        ->maxLength(20),      
                    ]),            
                Tabs\Tab::make('Rechnung')
                    ->columns(columns: 4)
                    ->schema([ 

                        Fieldset::make('Rechnungseinstellungen')
                            ->columns(4)
                            ->schema([
                                Forms\Components\Select::make('invoice_type_id')
                                    ->label('Rechnungstyp')
                                    ->default(1)
                                    ->relationship('invoiceType', 'textde'),
                                Forms\Components\TextInput::make('invoice_mail')
                                    ->label('E-Mail Adresse')
                                    ->columnSpan(3)
                                    ->maxLength(80), 
                                Forms\Components\Checkbox::make('no_charge')
                                    ->label('Gratis')
                                    ->default(false)
                                    ->inLine(),
                                Forms\Components\Checkbox::make('no_membership')
                                    ->label('Kein Mitgliederbeitrag')
                                    ->inline(),
                                Forms\Components\Checkbox::make('simple_membership')
                                    ->label('Mitgliederbeitrag nicht optimieren')
                                    ->inline(),

                            ]),   

                        Fieldset::make('Rechnungsadresse')
                            ->columns(4)
                            ->schema([

                                Forms\Components\TextInput::make('invoice_name')
                                    ->columnSpan(4)
                                    ->label('Name')
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('invoice_address')
                                    ->label('Adresse')
                                    ->columnSpan(4)
                                    ->maxLength(80),
                                Forms\Components\TextInput::make('invoice_address2')
                                    ->label('Adresse 2')
                                    ->columnSpan(4)
                                    ->maxLength(80),
                Forms\Components\TextInput::make('invoice_address3')
                    ->label('Adresse 3')
                    ->columnSpan(4)
                    ->maxLength(80),
                Forms\Components\TextInput::make('invoice_street')
                    ->label('Strasse')
                    ->columnSpan(4)                
                    ->maxLength(80),
                Forms\Components\TextInput::make('invoice_country')
                    ->label('Land')
                    ->columnSpan(1)
                    ->maxLength(20),
                Forms\Components\TextInput::make('invoice_postal_code')
                    ->columnSpan(1)
                    ->maxLength(20),
                Forms\Components\TextInput::make('invoice_city')
                    ->columnSpan(2)
                    ->maxLength(80),
                            ]),

                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('salutation')
                    ->label('Anrede'),
                Tables\Columns\TextColumn::make('name')
                     ->label('Name')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('address')
                    ->label('Adresse')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address2')
                    ->label('Adresse')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->label('Postleitzahl')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('city')
                    ->label('Stadt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->label('Land'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mail')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('contact')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('remarks')
                //     ->label('Bemerkungen'),
                // Tables\Columns\TextColumn::make('language.textde')
                //     ->label('Sprache'),
                // Tables\Columns\TextColumn::make('labType.textde')
                //     ->numeric(),
                // Tables\Columns\TextColumn::make('labGroup.textde')
                //     ->numeric(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->headerActions([
                ExportAction::make()->exporter(AddressExporter::class)
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
            RelationManagers\SubscriptionsRelationManager::class,
            RelationManagers\SchedulesRelationManager::class,
            RelationManagers\ShippingsRelationManager::class,
            RelationManagers\ProtocolsRelationManager::class,
            RelationManagers\ResultsRelationManager::class,           
            RelationManagers\CertificateRelationManager::class,
            RelationManagers\JournalsRelationManager::class,
            RelationManagers\InvoicesRelationManager::class,
            RelationManagers\ZsrglnsRelationManager::class,
            RelationManagers\TimelinesRelationManager::class,
            RelationManagers\VersionsRelationManager::class,
            RelationManagers\StaffRelationManager::class,
            RelationManagers\SterilizersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
}
