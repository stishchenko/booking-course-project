<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderSteps;
use App\Services\OrderService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_null_order_service()
    {
        $orderDto = OrderService::transformData(null);
        $this->assertIsArray($orderDto);
        $this->assertEmpty($orderDto);
    }

    public function test_empty_order_service()
    {
        $orderDto = OrderService::transformData([]);
        $this->assertIsArray($orderDto);
        $this->assertEmpty($orderDto);
    }

    public function test_order_service()
    {
        $orderData = [
            'company_id' => 1,
            'service_id' => 1,
            'employee_id' => 1,
            'client_name' => 'name',
            'client_phone' => '12345678',
            'price' => '100',
        ];
        $order = Order::create($orderData);
        $order->slot()->create([
            'date' => date('Y-m-d'),
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'duration' => '60',
            'schedule_id' => 1,
        ]);

        $orderDto = OrderService::transformData([$order]);
        $this->assertNotNull($orderDto);
        $this->assertIsArray($orderDto);
        $this->assertArrayHasKey('none', $orderDto);
    }

}
