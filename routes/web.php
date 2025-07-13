use App\Http\Controllers\ResultUpdateController;

Route::post('/filament/resources/addresses/{address}/update-results', [ResultUpdateController::class, 'update'])
    ->name('filament.resources.addresses.update-results');