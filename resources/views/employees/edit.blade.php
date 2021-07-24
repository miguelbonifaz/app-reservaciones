<x-app-layout header-title="{{ $employee->present()->name() }}">
    <x-ui.flash/>
    <div class="mx-auto max-w-7xl">
        <div class="py-4">
            <x-forms.employee
                :route="route('employees.update',$employee)"
                :employee="$employee"
                :schedules="$schedules"
                :services="$services"
                :daysOfWeek="$daysOfWeek ?? []"
            />
        </div>
    </div>
</x-app-layout>
