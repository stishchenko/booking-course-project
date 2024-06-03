@extends('mainApp')

@section('content')
    @foreach($employees as $employee)
        @include(
            'components.employeeCard',
            [
                'id'       => $employee->id,
                'name'     => $employee->name,
                'position' => $employee->position,
                'company_name' => $employee->company->name,
            ]
        )
    @endforeach
@endsection
