<?php

namespace App\Filament\Widgets;

use App\Models\Survey;
use Filament\Widgets\Widget;

class TextWidget extends Widget
{


    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 1;

    protected static string $view = 'filament.widgets.text-widget';

    public function data(): string
    {

        $tests=Survey::where('shipping','>',now())->orderby('shipping','asc')->limit(1)->get();
        $current_survey=$tests->first()->quarter . '-' . $tests->first()->year;
        
        return $current_survey ;
    }


}
