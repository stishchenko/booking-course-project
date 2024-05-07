@extends('mainApp')

@section('content')
    <div class="row justify-content-center align-items-center">
        <form class="col text-center" method="POST" action="{{ route('save-order') }}">
            @csrf
            <h1 class="mb-4">Confirm Order</h1>
            <div class="row mb-3">
                <label for="name" class="col">Full Name:</label>
                <input type="text" class="col" name="name" value="{{isset($user) ? $user->name : ''}}">
            </div>
            <div class="row mb-3">
                <label for="phone" class="col">Phone:</label>
                <input type="text" class="col" name="phone">
            </div>
            <div class="row mb-3">
                <label for="service" class="col">Service:</label>
                <input type="text" class="col" name="service" value="{{ $service->name }}" readonly>
            </div>
            <div class="row mb-3">
                <label for="master" class="col">Master:</label>
                <input type="text" class="col" name="master" value="{{ $employee->name }}" readonly>
            </div>
            <div class="row mb-3">
                <label for="price" class="col">Price:</label>
                <input type="text" class="col" name="price" value="{{ $service->price }}" readonly>
            </div>
            <div class="row mb-3">
                <label for="date" class="col">Date:</label>
                <input type="text" class="col" name="date" value="{{ $date }}" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Confirm Order</button>
        </form>
    </div>
@endsection
