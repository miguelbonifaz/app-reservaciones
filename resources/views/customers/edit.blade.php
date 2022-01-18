<x-app-layout header-title="{{ $customer->present()->name() }}">
    <div class="px-4">
        <div class="mx-auto max-w-7xl">
            <x-ui.flash />
            <div class="py-4">
                <x-forms.customer
                    :route="route('customers.update',$customer)"
                    :customer="$customer"
                />
            </div>
        </div>
    </div>
</x-app-layout>
