<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Order;
use App\Models\OrderSteps;
use App\Services\OrderPartsService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BookingController extends Controller
{
    public function __construct(protected OrderPartsService $orderPartsService)
    {
    }

    public function index()
    {
        OrderSteps::getInstance()->renew();
        return view('pages.index', ['companies' => $this->orderPartsService->getCompanies(),
            'user' => Auth::check() ? Auth::user() : null, 'useProgressBar' => false]);
    }

    public function services()
    {
        return view('pages.services',
            [
                'services' => $this->orderPartsService->getServices(),
                'user' => Auth::check() ? Auth::user() : null,
                'useProgressBar' => true,
            ]);
    }

    public function employees()
    {
        return view('pages.employees',
            [
                'employees' => $this->orderPartsService->getEmployees(),
                'user' => Auth::check() ? Auth::user() : null,
                'useProgressBar' => true,
            ]);
    }

    public function schedule()
    {
        return view('pages.schedules',
            [
                'slots' => $this->orderPartsService->getSchedule(),
                'user' => Auth::check() ? Auth::user() : null,
                'useProgressBar' => true,
            ]);
    }

    public function confirmation()
    {
        $orderSteps = OrderSteps::getInstance();
        return view('pages.confirmation',
            [
                'company' => $orderSteps->getCompany(),
                'service' => $orderSteps->getService(),
                'employee' => $orderSteps->getEmployee(),
                'date' => $orderSteps->getDate() . ' ' . $orderSteps->getTime(),
                'user' => Auth::check() ? Auth::user() : null,
                'useProgressBar' => true,
                'confirm' => false
            ]);
    }

    public function finishedOrder(int $id)
    {
        return view('pages.finishedOrder',
            [
                'order' => Order::find($id),
                'user' => Auth::check() ? Auth::user() : null,
                'useProgressBar' => true,
                'confirm' => true,
                'clear' => true,
            ]);
    }

    public function orders(Request $request)
    {
        if (Gate::denies('view-orders')) {
            abort(403, 'You are not allowed to view orders');
        }
        $groupType = $request->input('order', 'none');
        $orders = OrderService::transformData(Order::with('company', 'service', 'employee', 'slot')->get(), $groupType);
        return view('pages.orders', ['ordersArray' => $orders, 'orderType' => $groupType, 'user' => Auth::user(), 'useProgressBar' => false]);
    }
}
