<div class="col">
    <div class="card mb-4 rounded-3 shadow-sm" style="width: 15rem;">
        <div class="card-header py-3">
            <h4 class="my-0 fw-normal">{{ strtoupper($name) }} <br>({{ $date }})</h4>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach($slots as $slot)
                    <li class="list-group-item">
                        {{ $slot['start_time'] }}

                        <a href="{{ route('save-step', ['entity' => 'time-slot', 'data' => $date . ' ' . $slot['start_time'] ]) }}"
                           class="btn btn-primary btn-sm ms-5">
                            Select
                        </a>

                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
