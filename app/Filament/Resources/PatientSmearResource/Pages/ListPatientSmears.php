<?php

namespace App\Filament\Resources\PatientSmearResource\Pages;

use App\Filament\Resources\PatientSmearResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatientSmears extends ListRecords
{
    protected static string $resource = PatientSmearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
