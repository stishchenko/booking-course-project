<div class="row align-items-center">
    <div class="col-1">
        {{ $order->id }}
    </div>
    <div class="col">
        {{ $order->employee }}
    </div>
    <div class="col">
        {{ $order->service }}
    </div>
    <div class="col">
        {{ $order->price }} UAN.
    </div>
    <div class="col">
        {{ $order->duration }} min.
    </div>
    <div class="col-3">
        {{ $order->date }}
    </div>
    <div class="col">
        {{ $order->startTime }}
    </div>
    <div class="col">
        {{ $order->clientName }}
    </div>
    <div class="col">
        {{ $order->clientPhone }}
    </div>
</div>
