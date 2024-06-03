<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Employee;
use App\Models\OrderSteps;
use App\Models\Service;

class OrderPartsService
{

    public function getCompanies()
    {
        return Company::all();
    }

    public function getServices()
    {
        $orderInstance = OrderSteps::getInstance();
        $employee = $orderInstance->getEmployee();
        if ($employee !== null) {
            return $employee->services;
        }
        return $orderInstance->getCompany() !== null ? $orderInstance->getCompany()->services : Service::all();
    }

    public function getEmployees()
    {
        $orderInstance = OrderSteps::getInstance();
        $service = $orderInstance->getService();
        if ($service !== null) {
            return $service->employees()->where('company_id', $orderInstance->getCompany()->id)->get();
        }
        $orderInstance->setFirstEntity('employee');
        return $orderInstance->getCompany() !== null
            ? $orderInstance->getCompany()->employees
            : Employee::all();
    }

    public function getSchedule()
    {
        $orderInstance = OrderSteps::getInstance();
        $timeSlotsService = new TimeSlotsService($orderInstance->getEmployee());
        $timeSlots = $timeSlotsService->calculateTimeSlots($orderInstance->getService()->duration);
        return
            count($timeSlots) > 0
                ? $timeSlots
                : 'No free time slots for next seven days';
    }
}
