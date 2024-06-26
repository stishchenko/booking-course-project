<?php

namespace App\Services;

use App\Dtos\OrderDto;

class OrderService
{
    public static function transformData($orders, $groupBy = 'none')
    {
        if (empty($orders)) {
            return [];
        }
        $orderArray = [];

        foreach ($orders as $order) {
            $orderDto = new OrderDto();
            $orderDto->id = $order->id;
            $orderDto->company = $order->company->name;
            $orderDto->service = $order->service->name;
            $orderDto->employee = $order->employee->name;
            $orderDto->price = $order->service->price;
            $orderDto->duration = $order->service->duration;
            $orderDto->date = $order->slot->date;
            $orderDto->startTime = $order->slot->start_time;
            $orderDto->clientName = $order->client_name;
            $orderDto->clientPhone = $order->client_phone;
            $orderArray[] = $orderDto;
        }
        return $groupBy === 'none' ? ['none' => $orderArray] : collect($orderArray)->groupBy($groupBy)->toArray();
    }
}
