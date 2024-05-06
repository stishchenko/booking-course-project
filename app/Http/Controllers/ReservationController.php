<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderSteps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    public function saveProgress(Request $request)
    {
        $data = $request->validate([
            'entity' => ['required', 'string', Rule::in(['service', 'employee', 'time-slot'])],
            'data' => 'required',
        ]);
        $stepHandler = OrderSteps::getInstance();
        $stepHandler->setStep($data['entity'], $data['data']);

        $nextStep = $stepHandler->getNextStep();

        if ($nextStep === OrderSteps::CONFIRMATION) {
            //dd($stepHandler->getService()->id, $stepHandler->getEmployee()->id, $stepHandler->getDate(), $stepHandler->getTime(), $stepHandler->getPrice());
            $this->createOrder($stepHandler);
            $stepHandler->renew();
        }

        return redirect()->route($this->getRouteForStep($nextStep));
    }

    private function getRouteForStep(?string $nextStep): string
    {
        return OrderSteps::stepToRoutesMapping[$nextStep] ?? 'pages.services';
    }

    private function createOrder(OrderSteps $stepHandler): void
    {
        $orderData = [
            'company_id' => $stepHandler->getCompany()->id,
            'service_id' => $stepHandler->getService()->id,
            'employee_id' => $stepHandler->getEmployee()->id,
            'user_id' => Auth::check() ? Auth::id() : null,
            'date' => $stepHandler->getDate(),
            'start_time' => $stepHandler->getTime(),
            'price' => $stepHandler->getPrice(),
            'duration' => $stepHandler->getService()->duration,
        ];
        dd($orderData);
        $order = Order::create($orderData);

    }
}
