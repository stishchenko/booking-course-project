<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderSteps;
use App\Models\Slot;
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

        /*if ($nextStep === OrderSteps::CONFIRMATION) {
            //dd($stepHandler->getService()->id, $stepHandler->getEmployee()->id, $stepHandler->getDate(), $stepHandler->getTime(), $stepHandler->getPrice());
            $this->createOrder($stepHandler);
            $stepHandler->renew();
        }*/

        return redirect()->route($this->getRouteForStep($nextStep));
    }

    public function saveOrder(Request $request)
    {
        $stepHandler = OrderSteps::getInstance();
        $this->createOrder($stepHandler, ['client_name' => $request->name, 'client_phone' => $request->phone]);
        $stepHandler->renew();

        return redirect()->route('pages.finished-order');
    }

    private function getRouteForStep(?string $nextStep): string
    {
        return OrderSteps::stepToRoutesMapping[$nextStep] ?? 'pages.services';
    }

    private function createOrder(OrderSteps $stepHandler, array $clientData): void
    {
        /*$slot = Slot::create([
            'date' => $stepHandler->getDate(),
            'start_time' => $stepHandler->getTime(),
            'duration' => $stepHandler->getService()->duration,
            'schedule_id' => $stepHandler->getEmployee()->schedule->id,
        ]);*/
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
        //dd($order, $order->slot);
    }
}
