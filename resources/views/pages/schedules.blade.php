@extends('app')

@section('content')
    @foreach($slots as $dateOfWeek => $slotsInfo)
        @include(
            'components.timeSlot',
            ['name' => $slotsInfo['date_name'], 'date' => $dateOfWeek, 'slots' => $slotsInfo['slots']]
        )
    @endforeach
@endsection
