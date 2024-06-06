@extends('mainApp')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col text-center">
            <h3 class="mb-4">Thank you for your order!</h3>
            <p class="mb-4">Your order data:</p>
            <div class="row mb-3">
                Full Name: {{$order->client_name}}
            </div>
            <div class="row mb-3">
                Phone: {{ $order->client_phone }}
            </div>
            <div class="row mb-3">
                Company: {{ $order->company->name }}
            </div>
            <div class="row mb-3">
                Service: {{ $order->service->name }}
            </div>
            <div class="row mb-3">
                Master: {{ $order->employee->name }}
            </div>
            <div class="row mb-3">
                Price: {{ $order->price }} UAN
            </div>
            <div class="row mb-3">
                Visit: {{ $order->slot->date }} {{ $order->slot->start_time }}
            </div>
            <div class="row mb-3">
                Visit duration: {{ $order->service->duration }} min
            </div>
            <div class="row">
                <a href="/">Back to start page</a>
            </div>
        </div>
    </div>
@endsection
