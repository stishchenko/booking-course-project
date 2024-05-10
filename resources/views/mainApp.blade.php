@extends('layouts.main')


@php($chosenEntities = \App\Models\OrderSteps::getInstance())
@section('progressBar')
    @if($useProgressBar)
        @include(
                'components.progressBar',
                [
                    'employee'  => $chosenEntities?->getEmployee(),
                    'service' => $chosenEntities?->getService(),
                    'schedule' => $chosenEntities->getDate(),
                    'confirmation' => isset($confirm) ? $confirm : null,
                ]
        )
    @endif
@endsection
