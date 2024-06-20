<div class="col">
    <div class="card mb-4 rounded-3 shadow-sm" style="width: 15rem;">
        <div class="card-header py-3">
            <h4 class="my-0 fw-normal">{{ $name }} </h4>
        </div>
        <div class="card-body">
            <p class="card-text">From {{ $company_name }}</p>
            @if(!empty($description))
                <p class="card-text">{{ $description }}</p>
            @endif
            <p class="card-title pricing-card-title">{{ $price }} UAH <br><small
                    class="text-body-secondary fw-light">{{ $duration }} min.</small></p>
            <a href="{{ route('save-step', ['entity' => 'service', 'data' => ['entity_id'=>$id, 'company_id' => $company_id]]) }}"
               class="w-100 btn btn-lg btn-primary">Select</a>
        </div>
    </div>
</div>
