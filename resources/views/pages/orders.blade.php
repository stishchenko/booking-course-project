@extends('mainApp')

@section('content')

    <div class="col m-auto" style="width: fit-content">
        <h2>Orders</h2>
        <div class="row border-2 p-3 my-2">
            <form method="GET" action="{{ route("pages.orders") }}">
                Group by:
                <input type="radio" class="btn-check" name="order" id="none-order" value="none" autocomplete="off"
                    {{ $orderType == 'none' ? 'checked' : '' }}>
                <label class="btn" for="none-order">None</label>

                <input type="radio" class="btn-check" name="order" id="employee-order" value="employee"
                       autocomplete="off"
                    {{ $orderType == 'employee' ? 'checked' : '' }}>
                <label class="btn" for="employee-order">Employees</label>

                <input type="radio" class="btn-check" name="order" id="date-order" value="date" autocomplete="off"
                    {{ $orderType == 'date' ? 'checked' : '' }}>
                <label class="btn" for="date-order">Dates</label>

                <input type="submit" class="btn btn-outline-primary" value="Sort">
            </form>
        </div>
        <div class="row align-items-center">
            <div class="col-1">
                Id
            </div>
            <div class="col">
                Employee
            </div>
            <div class="col">
                Service
            </div>
            <div class="col">
                Price, UAN.
            </div>
            <div class="col">
                Duration, min.
            </div>
            <div class="col-3">
                Date
            </div>
            <div class="col">
                Time
            </div>
            <div class="col">
                Client name
            </div>
            <div class="col">
                Client phone
            </div>
        </div>
        @foreach($ordersArray as $key => $orders)
            @if($orderType !== 'none')
                <h4 class="row text-primary">For {{ $orderType }} {{ $key }}:</h4>
            @endif
            @foreach($orders as $order)
                @include(
                'components.orderPanel',
                [
                    'order' => $order
                ]
            )
            @endforeach
        @endforeach
    </div>
@endsection
