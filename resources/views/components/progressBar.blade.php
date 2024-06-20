<div class="container my-5">
    <ul id="progressbar">
        @switch($firstEntity)
            @case('service')
                <li class="{{ $service !=null ? "active" : "" }}">Service</li>
                <li class="{{ $employee !=null ? "active" : "" }}">Master</li>
                @break
            @case('employee')
                <li class="{{ $employee !=null ? "active" : "" }}">Master</li>
                <li class="{{ $service !=null ? "active" : "" }}">Service</li>
                @break
        @endswitch
        <li class="{{ $schedule !=null ? "active" : "" }}">Schedule</li>
        <li class="{{ $confirmation !=null ? "active" : "" }}">Confirmation</li>
    </ul>
</div>
@if(isset($clear))
    @php(\App\Models\OrderSteps::getInstance()->renew())
@endif
