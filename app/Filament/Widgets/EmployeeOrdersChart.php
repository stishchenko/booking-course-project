<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class EmployeeOrdersChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Orders by Employees';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $start = $this->filters['startDate'] ?? null;
        $end = $this->filters['endDate'] ?? null;
        $data = Employee::withCount(['orders as orders_count' => function ($query) use ($start, $end) {
            $query->when($start, fn($query) => $query->where('created_at', '>=', $start))
                ->when($end, fn($query) => $query->where('created_at', '<=', Carbon::parse($end)->endOfDay()));
        }])->pluck('orders_count', 'name');

        return [
            'datasets' => [
                [
                    'label' => 'Employees amount',
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
