<x-app-layout header-title="Nuevo Cliente">
    <div class="px-4">
        <div class="mx-auto max-w-7xl">
            <div class="py-4">
                <x-forms.customer
                    :route="route('customers.store')"
                    :customer="$customer"
                />
            </div>
        </div>
    </div>
</x-app-layout>
