<x-app-layout header-title="Nuevo Empleado">
    <div class="px-4">
        <div class="mx-auto max-w-7xl">
            <div class="py-4">
                <x-forms.employee
                    :route="route('employees.store')"
                    :employee="$employee"
                    :daysOfWeek="collect()"
                    :services="$services"
                />
            </div>
        </div>
    </div>
</x-app-layout>
