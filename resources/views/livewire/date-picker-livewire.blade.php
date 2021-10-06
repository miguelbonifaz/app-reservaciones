<div>
    <div class="space-y-2 bg-white border border-gray-200 rounded-xl pb-5">
        <div class="p-1 space-y-4">
            <header class="flex justify-between p-2">
                @if (!$this->isThePreviousMonth)
                    <div>
                        <svg wire:click="previousMonth"
                             class="cursor-pointer w-6 h-6"
                             fill="currentColor"
                             viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </div>
                @else
                    <div></div>
                @endif
                <p>{{ $this->monthName }}</p>
                <div>
                    <svg wire:click="nextMonth"
                         class="cursor-pointer  w-6 h-6"
                         fill="currentColor"
                         viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"></path>
                    </svg>
                </div>
            </header>
            <ul class="grid grid-cols-7 text-sm justify-items-center text-700 uppercase">
                <li>Lun</li>
                <li>Mar</li>
                <li>Mié</li>
                <li>Jue</li>
                <li>Vie</li>
                <li>Sáb</li>
                <li>Dom</li>
            </ul>
            <div class="pb-3 grid grid-cols-7 gap-y-3 text-sm justify-items-center text-700">
                @foreach ($this->daysOfMonth as $date => $day)
                    <p wire:key="{{ \Illuminate\Support\Str::uuid() }}"
                        @if ($this->isThisDayAvailable($date))
                            wire:click="selectDay('{{ $date }}')"
                        @endif
                        dusk="date-{{ $date }}"
                        class="font-bold flex justify-center items-center w-6 h-6 {{ $this->dayStyles($date) }} {{ $this->selectedDayStyles($date) }}">
                        {{ $day }}
                    </p>
                @endforeach
            </div>
        </div>
    </div>
</div>
