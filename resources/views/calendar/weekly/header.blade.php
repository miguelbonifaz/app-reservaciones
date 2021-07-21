<div class="flex flex-col justify-between lg:flex-row">

    <x-calendar.controls back="goToPreviousWeek" next="goToNextWeek" current="backToCurrentWeek">
        Semana Actual
    </x-calendar.controls>

    <x-calendar.date>
        {{$currentDay->copy()->startOfweek(\Carbon\Carbon::MONDAY)->format('F j, Y')}}
        -
        {{$currentDay->copy()->endOfWeek(\Carbon\Carbon::FRIDAY)->format('F j, Y')}}    
    </x-calendar.date>
    
</div>
<div class="h-2"></div>