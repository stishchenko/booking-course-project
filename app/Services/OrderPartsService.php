<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Employee;
use App\Models\OrderSteps;
use App\Models\Service;

class OrderPartsService
{
    public function getServices()
    {
        $orderInstance = OrderSteps::getInstance();
        $employee = $orderInstance->getEmployee();
        return $employee != null ? $employee->services : $orderInstance->getCompany()->services;
    }

    public function getEmployees()
    {
        $orderInstance = OrderSteps::getInstance();
        $service = $orderInstance->getService();
        return $service != null
            ? $service->employees()->where('company_id', $orderInstance->getCompany()->id)->get()
            : $orderInstance->getCompany()->employees;
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
