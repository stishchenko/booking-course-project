<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class ServiceOrdersChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Orders by Services';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $start = $this->filters['startDate'];
        $end = $this->filters['endDate'];
        $data = Service::withCount(['orders as orders_count' => function ($query) use ($start, $end) {
            $query->when($start, fn($query) => $query->where('created_at', '>=', $start))
                ->when($end, fn($query) => $query->where('created_at', '<=', Carbon::parse($end)->endOfDay()));
        }])->pluck('orders_count', 'name');

        return [
            'datasets' => [
                [
                    'label' => 'Services amount',
                    'data' => $data->values(),
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
