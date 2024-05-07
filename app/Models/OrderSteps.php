<?php

namespace App\Models;

use InvalidArgumentException;
use Illuminate\Support\Facades\Session;

class OrderSteps
{
    public const CONFIRMATION = 'confirmation';
    public const SCHEDULE = 'schedules';
    public const STAFF = 'employees';
    public const SERVICES = 'services';

    public const stepToRoutesMapping = [
        OrderSteps::CONFIRMATION => 'pages.confirmation',
        OrderSteps::SCHEDULE => 'pages.schedules',
        OrderSteps::STAFF => 'pages.employees',
        OrderSteps::SERVICES => 'pages.services',
    ];

    protected ?Service $service = null;
    protected ?Employee $employee = null;
    protected ?Company $company = null;
    protected ?string $date = null;
    protected ?string $time = null;

    public function __construct()
    {
        $this->setCompany(1);
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    protected function setService(int $serviceId): void
    {
        $service = Service::findOrFail($serviceId);
        $this->service = $service;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    protected function setEmployee(int $employeeId): void
    {
        $employee = Employee::findOrFail($employeeId);
        $this->employee = $employee;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    protected function setCompany(int $companyId): void
    {
        $company = Company::findOrFail($companyId);
        $this->company = $company;
    }

    public function getNextStep(): ?string
    {
        $isServiceSet = $this->service !== null;
        $isEmployeeSet = $this->employee !== null;
        $isCompanySet = $this->company !== null;
        $isScheduleSet = $this->date !== null && $this->time !== null;

        if ($isCompanySet && $isServiceSet && $isEmployeeSet && $isScheduleSet) {
            return self::CONFIRMATION;
        }
        if ($isCompanySet && $isServiceSet && $isEmployeeSet) {
            return self::SCHEDULE;
        }
        if ($isCompanySet && $isServiceSet) {
            return self::STAFF;
        }
        if ($isCompanySet && $isEmployeeSet) {
            return self::SERVICES;
        }

        return null;
    }

    public function setStep(mixed $entity, mixed $data): void
    {
        switch ($entity) {
            case 'service':
                $this->setService($data);
                break;
            case 'employee':
                $this->setEmployee($data);
                break;
            case 'company':
                $this->setCompany($data);
                break;
            case 'time-slot':
                $dateTime = \DateTime::createFromFormat('Y-m-d H:i', $data);
                if (!$dateTime) {
                    throw new InvalidArgumentException('Wrong date time for service');
                }
                $this
                    ->setDate($dateTime)
                    ->setTime($dateTime);

                break;
        }
        $this->flush();
    }

    public static function getInstance(): OrderSteps
    {
        $entityFromSession = Session::has('order_steps') ? Session::get('order_steps') : new self();
        Session::put('order_steps', $entityFromSession);

        return $entityFromSession;
    }

    private function flush(): void
    {
        Session::put('order_steps', $this);
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    private function setDate(\DateTime $dateTime): self
    {
        $this->date = $dateTime->format('d-m-y');

        return $this;
    }

    private function setTime(\DateTime|bool $dateTime): self
    {
        $this->time = $dateTime->format('H:i');

        return $this;
    }


    public function getPrice(): int
    {
        $basePrice = $this->getService()->price;
        //some additional logic could be added like promo, coupons, etc
        return $basePrice;
    }

    public function renew()
    {
        Session::forget('order_steps');
    }
}
