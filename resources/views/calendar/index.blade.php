<x-app-layout max-width="''" header-title="Calendario">
    <x-ui.flash />


    <livewire:weekly-calendar-livewire
        starting-hour="8"
        ending-hour="20"
        interval="10"
        before-grid-view="calendar/weekly/header"
    />


</x-app-layout>
