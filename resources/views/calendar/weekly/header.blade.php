<div class="flex flex-col justify-between lg:flex-row">

    <x-calendar.controls back="goToPreviousWeek" next="goToNextWeek" current="backToCurrentWeek">
        Semana Actual
    </x-calendar.controls>

    <div class="order-0 mb-3 lg:order-1 lg:mb-0">
        <a href="{{route('appointments.create')}}"
           class="inline-flex items-center px-4 py-3 bg-gray-800 border border-transparent rounded-md text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'">
            Crear Reservación
        </a>
    </div>

    <x-calendar.date>
        {{$currentDay->copy()->startOfweek()->day_month_year()}}
        -
        {{$currentDay->copy()->endOfWeek()->day_month_year()}}
    </x-calendar.date>

</div>
<div class="h-2"></div>
