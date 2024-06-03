@extends('layouts.main')

@php($chosenEntities = \App\Models\OrderSteps::getInstance())
@section('progressBar')
    @if($useProgressBar)
        @include(
                'components.progressBar',
                [
                    'firstEntity' => $chosenEntities->getFirstEntity(),
                    'employee'  => $chosenEntities?->getEmployee(),
                    'service' => $chosenEntities?->getService(),
                    'schedule' => $chosenEntities->getDate(),
                    'confirmation' => $confirm ?? null,
                ]
        )
    @endif
@endsection

