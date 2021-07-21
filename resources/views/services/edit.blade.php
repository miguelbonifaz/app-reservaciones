<x-app-layout header-title="{{ $service->present()->name() }}">
    <div class="px-4">
        <div class="mx-auto max-w-7xl">
            <div class="py-4">
                <x-forms.service
                    :route="route('services.update',$service)"
                    :service="$service"
                />
            </div>
        </div>
    </div>
</x-app-layout>
