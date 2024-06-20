<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Employee;
use App\Models\OrderSteps;
use App\Models\Service;
use App\Services\OrderPartsService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderPartsServiceTest extends TestCase
{
    use RefreshDatabase;

    private OrderPartsService $orderPartsService;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->orderPartsService = new OrderPartsService();
        $orderInstance = OrderSteps::getInstance();
        $orderInstance->setStep('company', 1);
    }

    public function tearDown(): void
    {
        OrderSteps::getInstance()->renew();
        parent::tearDown();
    }

    public function test_get_companies()
    {
        $companies = $this->orderPartsService->getCompanies();
        $this->assertNotEmpty($companies);
        $companies->each(fn($company) => $this->assertInstanceOf(Company::class, $company));
    }

    public function test_get_services()
    {
        $services = $this->orderPartsService->getServices();
        $this->assertNotEmpty($services);
        $services->each(fn($service) => $this->assertInstanceOf(Service::class, $service));
    }

    public function test_get_services_by_employee()
    {
        $orderInstance = OrderSteps::getInstance();
        $employee = $orderInstance->getCompany()->employees()->first();
        $orderInstance->setStep('employee', $employee->id);
        $services = $this->orderPartsService->getServices();
        $this->assertNotEmpty($services);
        $services->each(function ($service) use ($orderInstance) {
            $this->assertInstanceOf(Service::class, $service);
            $this->assertGreaterThan(0, $service->employees()->where('employees.id', $orderInstance->getEmployee()->id)->count());
        });
    }

    public function test_get_employees()
    {
        $employees = $this->orderPartsService->getEmployees();
        $this->assertNotEmpty($employees);
        $employees->each(fn($employee) => $this->assertInstanceOf(Employee::class, $employee));
    }

    public function test_get_employees_by_service()
    {
        $orderInstance = OrderSteps::getInstance();
        $service = $orderInstance->getCompany()->services()->first();
        $orderInstance->setStep('service', $service->id);
        $employees = $this->orderPartsService->getEmployees();
        $this->assertNotEmpty($employees);
        $employees->each(function ($employee) use ($orderInstance) {
            $this->assertInstanceOf(Employee::class, $employee);
            $this->assertGreaterThan(0, $employee->services()->where('services.id', $orderInstance->getService()->id)->count());
        });
    }

    public function test_get_schedule()
    {
        $orderInstance = OrderSteps::getInstance();
        $service = $orderInstance->getCompany()->services()->first();
        $orderInstance->setStep('service', $service->id);
        $employees = $this->orderPartsService->getEmployees();
        $orderInstance->setStep('employee', $employees->get(0)->id);
        $schedule = $this->orderPartsService->getSchedule();
        $this->assertNotEmpty($schedule);
        if (!is_array($schedule)) {
            $this->assertIsString($schedule);
        }
    }
}
