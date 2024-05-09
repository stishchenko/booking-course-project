@extends('mainApp')

@section('headerTitle', 'Booking service')
@section('headerDescription', 'Please choose a service to book.')

{{--
@php($chosenEntities = \App\Models\OrderSteps::getInstance())
@section('breadcrumds')

    @include(
            'components.breadcrumbs',
            [
                'worker'  => $chosenEntities ? $chosenEntities->getWorker() : null,
                'service' => $chosenEntities ? $chosenEntities->getService() : null,
            ]
    )
@endsection--}}
