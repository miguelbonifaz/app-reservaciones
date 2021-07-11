<x-app-layout header-title="{{ $employee->present()->name() }}">
    <div class="px-4">
        <div class="mx-auto max-w-7xl">
            <div class="py-4">
                <x-forms.employee
                    :route="route('employees.update',$employee)"
                    :employee="$employee"
                />
            </div>
        </div>
    </div>
</x-app-layout>
