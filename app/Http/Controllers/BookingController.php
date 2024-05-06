<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\OrderSteps;
use App\Models\Service;
use App\Services\TimeSlotsService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        OrderSteps::getInstance()->renew();
        return view('app');
    }

    public function services()
    {
        $hasEmployee = OrderSteps::getInstance()->getEmployee();
        return view('pages.services', ['services' => $hasEmployee != null ? $hasEmployee->services()->get() :
            Service::all()]);
    }

    public function employees()
    {
        $hasService = OrderSteps::getInstance()->getService();
        return view('pages.employees', ['employees' => $hasService != null ? $hasService->employees()->get() :
            Employee::all()]);
    }

    public function schedule()
    {
        $timeSlotsService = new TimeSlotsService(OrderSteps::getInstance()->getEmployee());
        $timeSlots1 = $timeSlotsService->calculateTimeSlots(OrderSteps::getInstance()->getService()->duration);
        return view('pages.schedules')->with('slots', $timeSlots1);
    }

    public function confirmation()
    {
        return view('pages.confirmation');
    }
}
