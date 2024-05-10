<?php

namespace App\Http\Controllers;

use App\Dtos\OrderDto;
use App\Dtos\SlotsDto;
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderSteps;
use App\Models\Service;
use App\Services\OrderService;
use App\Services\TimeSlotsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BookingController extends Controller
{
    public function index()
    {
        /*$employee = Employee::find(1);
        dd($employee->schedule->slots()->where('start_time', '10:00')->get());*/
        OrderSteps::getInstance()->renew();

        return view('pages.index', ['user' => Auth::check() ? Auth::user() : null, 'useProgressBar' => false]);
    }

    public function services()
    {
        $hasEmployee = OrderSteps::getInstance()->getEmployee();
        return view('pages.services', ['services' => $hasEmployee != null ? $hasEmployee->services()->get() :
            Service::all(), 'user' => Auth::check() ? Auth::user() : null, 'useProgressBar' => true]);
    }

    public function employees()
    {
        $hasService = OrderSteps::getInstance()->getService();
        return view('pages.employees', ['employees' => $hasService != null ? $hasService->employees()->get() :
            Employee::all(), 'user' => Auth::check() ? Auth::user() : null, 'useProgressBar' => true]);
    }

    public function schedule()
    {
        $timeSlotsService = new TimeSlotsService(OrderSteps::getInstance()->getEmployee());
        $timeSlots1 = $timeSlotsService->calculateTimeSlots(OrderSteps::getInstance()->getService()->duration);
        return view('pages.schedules', ['slots' => $timeSlots1, 'user' => Auth::check() ? Auth::user() :
            null, 'useProgressBar' => true]);
    }

    public function confirmation()
    {
        $orderSteps = OrderSteps::getInstance();
        return view('pages.confirmation',
            [
                'service' => $orderSteps->getService(),
                'employee' => $orderSteps->getEmployee(),
                'date' => $orderSteps->getDate() . ' ' . $orderSteps->getTime(),
                'user' => Auth::check() ? Auth::user() : null,
                'useProgressBar' => true,
                'confirm' => false
            ]);
    }

    public function finishedOrder()
    {
        //OrderSteps::getInstance()->renew();
        return view('pages.finishedOrder', ['user' => Auth::check() ? Auth::user() : null,
            'useProgressBar' => true, 'confirm' => true]);
    }

    public function orders(Request $request)
    {
        if (Gate::denies('view-orders')) {
            abort(403, 'You are not allowed to view orders');
        }
        $groupType = $request->input('order', 'none');
        $orders = OrderService::transformData(Order::with('service', 'employee', 'slot')->get(), $groupType);
        return view('pages.orders', ['ordersArray' => $orders, 'orderType' => $groupType, 'user' => Auth::user(), 'useProgressBar' => false]);
    }
}
