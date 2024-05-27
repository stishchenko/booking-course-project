<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\ScheduleRequest;
use App\Http\Requests\ServiceRequest;
use App\Models\Company;
use App\Models\Employee;
use App\Models\OrderSteps;
use App\Models\Service;
use App\Services\TimeSlotsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{

    public function services(ServiceRequest $request)
    {
        $data = $request->validated();
        if (!$this->checkIfCompanyExists($data['companyId'])) {
            return 'No such company';
        }
        $employee = isset($data['employeeId']) ?
            Employee::find($data['employeeId'])->where('company_id', $data['companyId'])->first()
            : null;
        return response()
            ->json(
                $employee != null
                    ? $employee->services
                    : 'No services for this employee'
            );
    }

    public function employees(EmployeeRequest $request)
    {
        $data = $request->validated();
        if (!$this->checkIfCompanyExists($data['companyId'])) {
            return 'No such company';
        }
        $service = isset($data['serviceId']) ?
            Service::find($data['serviceId'])
            : null;
        return response()
            ->json(
                $service != null
                    ? $service->employees()->where('company_id', $data['companyId'])->get()
                    : 'No employees for this services'
            );
    }

    public function schedule(ScheduleRequest $request)
    {
        $data = $request->validated();
        if (!$this->checkIfCompanyExists($data['companyId'])) {
            return 'No such company';
        }
        $employee = Employee::find($data['employeeId'])->where('company_id', $data['companyId'])->first();
        if ($employee === null) {
            return 'No such employee';
        }
        $service = $employee->services()->where('id', $data['serviceId'])->first();
        if ($service === null) {
            return 'No such service';
        }
        $timeSlotsService = new TimeSlotsService($employee);
        $timeSlots = $timeSlotsService->calculateTimeSlots($service->duration);
        return response()->json(
            count($timeSlots) > 0
                ? $timeSlots
                : 'No free time slots for next seven days'
        );
    }

    private function checkIfCompanyExists(int $companyId)
    {
        return Company::where('id', $companyId)->exists();
    }
}
