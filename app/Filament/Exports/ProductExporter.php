<?php

namespace App\Filament\Exports;

use App\Models\Product;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [

            ExportColumn::make('id'),
            ExportColumn::make('category_id'),
            ExportColumn::make('name')
              ->label('наименование'),
            ExportColumn::make('ed'),


            //
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Экспортировано успешно  ' . number_format($export->successful_rows) . ' ' . str('стр.')->plural($export->successful_rows) . ' !.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' строк.';
        }

        return $body;
    }
}
