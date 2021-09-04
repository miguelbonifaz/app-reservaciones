<div class="p-5">
    <h2 class="text-lg font-bold text-gray-800 mb-2">{{ $this->service->present()->name() }}</h2>
    <div class="space-y-2 bg-white rounded-xl pb-5">
        {{ $this->service->present()->description() }}
    </div>
</div>
