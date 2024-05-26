<?php

namespace App\Filament\Resources\PaymentResource\Widgets;

use App\Models\Payment;
use App\Filament\Resources\PaymentResource\Pages\ListPayments;
use Filament\Widgets\Widget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;




class PaymentOverview extends BaseWidget
{

    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListPayments::class;
    }


    protected function getStats(): array
    {

     return [

            Stat::make('Всего открытых оплат', $this->getPageTableQuery()->whereIn('status', ['open', 'processing'])->count()),
            Stat::make('Всего сумма', number_format($this->getPageTableQuery()->sum('psum'), 2)),
        ];
    }
}
