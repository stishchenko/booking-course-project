@extends('app')

@section('content')
    @foreach($employees as $employee)
        @include(
            'components.employeeCard',
            [
                'name'     => $employee->name,
                'position' => $employee->position,
                'id'       => $employee->id,
            ]
        )
    @endforeach
@endsection
