<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Service;
use App\Services\TimeSlotsService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function services()
    {
        return view('pages.services', ['services' => Service::all()]);
    }

    public function employees()
    {
        return view('pages.employees', ['employees' => Employee::all()]);
    }

    public function schedule()
    {
        $employee = Employee::find(1);
        $timeSlotsService = new TimeSlotsService($employee);
        $timeSlots1 = $timeSlotsService->calculateTimeSlots(60);
        return view('pages.schedules')->with('slots', $timeSlots1);
    }

    public function confirmation()
    {
        return view('pages.confirmation');
    }
}
