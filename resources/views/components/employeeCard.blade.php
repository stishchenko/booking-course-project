<div class="col">
    <div class="card mb-4 rounded-3 shadow-sm" style="width: 15rem;">
        <div class="card-header py-3">
            <h4 class="my-0 fw-normal">{{ $name }} </h4>
        </div>
        <div class="card-body">
            <p class="card-text">{{ $position }}</p>

            <a href="{{ route('save-step', ['entity' => 'employee', 'data' => $id]) }}"
               class="w-100 btn btn-lg btn-primary">Select</a>

        </div>
    </div>
</div>
