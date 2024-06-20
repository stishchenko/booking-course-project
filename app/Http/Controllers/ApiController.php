<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderSteps;
use App\Services\OrderPartsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function __construct(protected OrderPartsService $orderPartsService)
    {
    }

    public function index()
    {
        OrderSteps::getInstance()->renew();
        return ['companies' => $this->orderPartsService->getCompanies()];
    }

    public function services()
    {
        return response()->json(['services' => $this->orderPartsService->getServices()]);
    }

    public function employees()
    {
        return response()->json(['employees' => $this->orderPartsService->getEmployees()]);
    }

    public function schedule()
    {
        return response()->json(['schedule' => $this->orderPartsService->getSchedule()]);
    }

    public function confirmation()
    {
        $orderSteps = OrderSteps::getInstance();
        return response()->json(['order' => $orderSteps]);
    }

    public function finishedOrder()
    {
        //OrderSteps::getInstance()->renew();
        return 'Thank you for your order!';
    }

    //Save data about order
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

        return response()->json(['next-step' => $this->getRouteForStep($nextStep)]);
    }

    public function saveOrder(Request $request)
    {
        $stepHandler = OrderSteps::getInstance();
        $this->createOrder($stepHandler, ['client_name' => $request->client_name, 'client_phone' => $request->client_phone]);
        $stepHandler->renew();

        return redirect()->route('pages.api.finished-order');
    }

    private function getRouteForStep(?string $nextStep): string
    {
        return OrderSteps::stepToRoutesMapping[$nextStep] ?? 'pages.services';
    }

    private function createOrder(OrderSteps $stepHandler, array $clientData): void
    {
        $orderData = [
            'company_id' => $stepHandler->getCompany()->id,
            'service_id' => $stepHandler->getService()->id,
            'employee_id' => $stepHandler->getEmployee()->id,
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
    }
}
