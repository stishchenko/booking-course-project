@extends('app')

@section('content')
    @foreach($services as $service)
        @include(
            'components.serviceCard',
            [
                'name'     => $service->name,
                'price'    => $service->price,
                'duration' => $service->duration,
                'description' => $service->description,
                'id'       => $service->id,
            ]
        )
    @endforeach
@endsection
