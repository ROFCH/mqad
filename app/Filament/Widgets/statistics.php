<?php

namespace App\Filament\Widgets;

use App\Models\Address;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Database\Query\Builder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class statistics extends BaseWidget
{

    protected static ?int $sort = 2;



    protected function getStats(): array
    {

        $data=Subscription::query()
            ->where('stop_year',0)
            ->orWhere('stop_year','>=',date("Y"))
            ->distinct('address_id')   
            ->count()
            ;

        $data2=Product::query()
            ->where('sample','>',0)
            ->count();


        $data3=Subscription::query()
             ->where('stop_year',0)
             ->orWhere('stop_year','>=',date("Y"))
             ->count();

        return [
            Stat::make('Teilnehmer',$data),
            Stat::make('Ringversuche',$data2),
            Stat::make('Bestellte Proben',$data3)
                
        ];
    }
}
