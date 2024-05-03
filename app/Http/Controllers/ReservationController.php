<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderSteps;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    public function saveProgress(Request $request)
    {
        $data = $request->validate([
            'entity' => ['required', 'string', Rule::in(['service', 'worker', 'time-slot'])],
            'data' => 'required',
        ]);
        $stepHandler = OrderSteps::getInstance();
        $stepHandler->setStep($data['entity'], $data['data']);

        $nextStep = $stepHandler->getNextStep();

        if ($nextStep === OrderSteps::CONFIRMATION) {
            dd($stepHandler->getService(), $stepHandler->getEmployee(), $stepHandler->getDate(), $stepHandler->getTime(), $stepHandler->getPrice());
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
            'companyId' => $stepHandler->getCompany()->id,
            'serviceId' => $stepHandler->getService()->id,
            'workerId' => $stepHandler->getEmployee()->id,
            'date' => $stepHandler->getDate(),
            'time' => $stepHandler->getTime(),
            'price' => $stepHandler->getPrice(),
            'duration' => $stepHandler->getService()->duration,
        ];

        $order = Order::create($orderData);

    }
}
