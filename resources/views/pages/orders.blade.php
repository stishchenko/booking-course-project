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

                <input type="radio" class="btn-check" name="order" id="employee-order" value="employees"
                       autocomplete="off"
                    {{ $orderType == 'employees' ? 'checked' : '' }}>
                <label class="btn" for="employee-order">Employees</label>

                <input type="radio" class="btn-check" name="order" id="date-order" value="dates" autocomplete="off"
                    {{ $orderType == 'dates' ? 'checked' : '' }}>
                <label class="btn" for="date-order">Dates</label>

                <input type="submit" class="btn btn-outline-primary" value="Sort">
            </form>
        </div>
        @foreach($orders as $order)
            @include(
                'components.orderPanel',
                [
                    'order' => $order,
                    'orderType' => $orderType
                ]
            )
        @endforeach
    </div>
@endsection
