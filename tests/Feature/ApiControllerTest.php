<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Order;
use App\Models\OrderSteps;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $orderInstance = OrderSteps::getInstance();
        $orderInstance->setStep('company', 1);
    }

    public function tearDown(): void
    {
        OrderSteps::getInstance()->renew();
        parent::tearDown();
    }

    public function test_get_companies_success()
    {
        $response = $this->get('/api/');

        $response->assertStatus(200);
        $response->assertJsonIsArray('companies');
        $response->assertJsonCount(Company::count(), 'companies');

        $companies = $response->json('companies');
        $this->assertArrayHasKey('id', $companies[0]);
        $this->assertArrayHasKey('name', $companies[0]);
        $this->assertArrayHasKey('address', $companies[0]);
    }

    public function test_get_employees_success()
    {
        $response = $this->get('/api/employees');

        $response->assertStatus(200);
        $response->assertJsonIsArray('employees');
        $response->assertJsonCount(OrderSteps::getInstance()->getCompany()->employees()->count(), 'employees');

        $employees = $response->json('employees');
        $this->assertArrayHasKey('id', $employees[0]);
        $this->assertArrayHasKey('name', $employees[0]);
        $this->assertArrayHasKey('position', $employees[0]);
        $this->assertArrayHasKey('photo', $employees[0]);
    }

    public function test_get_services_success()
    {
        $response = $this->get('/api/services');

        $response->assertStatus(200);
        $response->assertJsonIsArray('services');
        $response->assertJsonCount(OrderSteps::getInstance()->getCompany()->services()->count(), 'services');

        $services = $response->json('services');
        $this->assertArrayHasKey('id', $services[0]);
        $this->assertArrayHasKey('name', $services[0]);
        $this->assertArrayHasKey('description', $services[0]);
        $this->assertArrayHasKey('duration', $services[0]);
        $this->assertIsInt($services[0]['duration']);
        $this->assertArrayHasKey('price', $services[0]);
        $this->assertIsNumeric($services[0]['price']);
    }

    public function test_get_schedule_success()
    {
        $orderInstance = OrderSteps::getInstance();
        $service = $orderInstance->getCompany()->services()->first();
        $orderInstance->setStep('service', $service->id);
        $employees = $orderInstance->getService()->employees()->where('company_id', $orderInstance->getCompany()->id)->get();
        $orderInstance->setStep('employee', $employees->get(0)->id);

        $response = $this->get('/api/schedule');

        $response->assertStatus(200);

        $schedule = $response->json('schedule');
        $this->assertIsArray($schedule);
        $item = $schedule[array_key_first($schedule)];
        $this->assertArrayHasKey('date_name', $item);
        $this->assertArrayHasKey('slots', $item);
    }

    public function test_confirmation_success()
    {
        $response = $this->get('/api/confirmation');

        $response->assertStatus(200);
        $response->assertJsonIsArray('order');
    }

    public function test_finish_order_success()
    {
        $response = $this->get('/api/finished-order');

        $response->assertStatus(200);
        $this->assertIsString($response->getContent());
    }

    public function test_save_step_success()
    {
        $response = $this->post('/api/save-step', ['entity' => 'service', 'data' => 1]);

        $response->assertStatus(200);
        $response->assertJsonPath('next-step', 'pages.employees');
        $nextStep = $response->json('next-step');
        $this->assertStringEndsWith(OrderSteps::getInstance()->getNextStep(), $nextStep);
        $this->assertNotNull(OrderSteps::getInstance()->getService());
    }

    public function test_save_order_success()
    {
        $orderInstance = OrderSteps::getInstance();
        $orderInstance->setStep('service', 1);
        $orderInstance->setStep('employee', 1);
        $orderInstance->setStep('time-slot', ['date' => date('Y-m-d'), 'start_time' => '10:00', 'end_time' => '11:00']);
        $response = $this->post('/api/save-order', ['client_name' => 'Jane', 'client_phone' => '12345678']);

        $response->assertStatus(302);
        $order = Order::find(1);
        $this->assertNotNull($order);
    }
}
