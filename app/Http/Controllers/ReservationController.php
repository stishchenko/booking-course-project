<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderSteps;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    public function saveProgress(Request $request)
    {
        $validator = Validator::make($request->all(), OrderSteps::getStepValidationRules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 406);
        }
        $data = $validator->validated();
        $stepHandler = OrderSteps::getInstance();
        $stepHandler->setStep($data['entity'], $data['data']);
        $nextStep = $stepHandler->getNextStep();

        return redirect()->route($this->getRouteForStep($nextStep));
    }

    public function saveOrder(Request $request)
    {
        $stepHandler = OrderSteps::getInstance();
        $orderId = $this->createOrder($stepHandler, ['client_name' => $request->name, 'client_phone' => $request->phone]);

        return redirect()->route('pages.finished-order', ['id' => $orderId]);
    }

    private function getRouteForStep(?string $nextStep): string
    {
        return OrderSteps::stepToRoutesMapping[$nextStep] ?? 'pages.services';
    }

    private function createOrder(OrderSteps $stepHandler, array $clientData): int
    {
        $orderData = [
            'company_id' => $stepHandler->getCompany()->id,
            'service_id' => $stepHandler->getService()->id,
            'employee_id' => $stepHandler->getEmployee()->id,
            'user_id' => Auth::check() ? Auth::id() : null,
            'client_name' => $clientData['client_name'],
            'client_phone' => $clientData['client_phone'],
            'price' => $stepHandler->getPrice(),
        ];
        $order = Order::create($orderData);
        $order->slot()->create([
            'date' => $stepHandler->getDate(),
            'start_time' => $stepHandler->getTime(),
            'end_time' => $stepHandler->getEndTime(),
            'duration' => $stepHandler->getService()->duration,
            'schedule_id' => $stepHandler->getEmployee()->schedule->id,
        ]);

        return $order->id;
    }
}
