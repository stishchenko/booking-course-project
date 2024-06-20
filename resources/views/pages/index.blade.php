@extends('mainApp')

@section('headerTitle', 'Booking service')
@section('headerDescription', 'Please choose a company to book.')

@section('content')
    @foreach($companies as $company)
        @include(
            'components.companyCard',
            [
                'name'     => $company->name,
                'address'    => $company->address,
                'id'       => $company->id,
            ]
        )
    @endforeach
@endsection
