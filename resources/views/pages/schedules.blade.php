@extends('app')

@section('content')
    @foreach($slots as $dayOfTheWeek => $slotsInfo)
        @include(
            'components.timeSlot',
            ['name' => $dayOfTheWeek, 'date' => $slotsInfo['date'], 'slots' => $slotsInfo['slots']]
        )
    @endforeach
@endsection
