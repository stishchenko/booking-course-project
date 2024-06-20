@extends('mainApp')

@section('content')
    @foreach($services as $service)
        @foreach($service->companies as $company)
            @include(
                'components.serviceCard',
                [
                    'id'       => $service->id,
                    'name'     => $service->name,
                    'price'    => $service->price,
                    'duration' => $service->duration,
                    'description' => $service->description,
                    'company_name' => $company->name,
                    'company_id'       => $company->id,
                ]
            )
        @endforeach
    @endforeach
@endsection
