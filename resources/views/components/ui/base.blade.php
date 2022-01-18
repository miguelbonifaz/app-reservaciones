<div class="{{-- shadow  --}}sm:rounded-md">
    <div class="px-4 py-5 bg-white sm:p-6 sm:rounded-md">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            {{ $slot }}
        </div>
    </div>
    @if ($footer ?? false)
        <div class="flex justify-end px-4 py-3 space-x-3 text-right bg-gray-50 sm:px-6">
            {{ $footer }}
        </div>
    @endif
</div>
