<x-base-form route="{{ $route }}">
    <div class="sm:col-span-2">
        <p class="mb-2 text-lg font-bold text-gray-800">Información Empleado</p>
        <hr class="border-t border-gray-200 sm:col-span-2">
    </div>

    <x-input.text
        name="name"
        value="{{old('name', $employee->name)}}"
        label="Nombre"
    />

    <x-input.text
        name="email"
        value="{{old('email', $employee->email)}}"
        label="email"
    />

    <x-input.text
        name="phone"
        value="{{old('phone', $employee->phone)}}"
        label="Teléfono"
    />
    <div class="sm:col-span-2">
        <p class="mb-2 text-lg font-bold text-gray-800">Asignación de servicios</p>
        @foreach ($services as $service)
            <div class="inline-flex items-center py-2 px-4 mt-1 mr-2 mb-2 space-x-1 bg-gray-50 rounded-full shadow-sm">
                <input
                    {{ collect(old('servicesId', $employee->services->pluck('id')))->contains($service->id) ? 'checked' : '' }}
                    id="service_{{ $service->id }}"
                    name="servicesId[]"
                    value="{{ $service->id }}"
                    type="checkbox"
                    class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                <label
                    for="service_{{ $service->id }}"
                    class="block ml-2 text-sm text-gray-900">
                    {{ $service->present()->name() }}
                </label>
            </div>
        @endforeach
    </div>
    @if ($employee->schedules->isNotEmpty())
        <div class="sm:col-span-2">
            <p class="mb-2 text-lg font-bold text-gray-800">Horario de trabajo</p>
            <div class="grid gap-2 md:grid-cols-2 md:items-start">
                @foreach ($schedules as $schedule)
                    <div class="py-2 px-4 mt-1 mr-2 mb-2 space-y-1 bg-gray-50 rounded-lg shadow-sm">
                        <div>
                            <label for="monday" class="block mb-1 ml-2 font-semibold text-gray-800">
                                {{ $schedule->present()->dayOfWeek() }}
                            </label>
                        </div>
                        <div class="sm:grid sm:grid-cols-2 sm:gap-2">
                            <div>
                                <x-select-with-hours
                                    label="Hora de inicio"
                                    name="start_time[{{ $schedule->day }}]"
                                    :value="$schedule->start_time"
                                />
                            </div>
                            <div>
                                <x-select-with-hours
                                    label="Hora de salida"
                                    name="end_time[{{ $schedule->day }}]"
                                    :value="$schedule->end_time"
                                />
                            </div>
                        </div>
                        @foreach ($schedule->rests as $rest)
                            <div class="sm:grid sm:grid-cols-2 sm:gap-2 pt-3">
                                @if ($loop->index == false)
                                    <p class="sm:col-span-2 font-bold text-gray-800">Horario de descanso</p>
                                @endif
                                <div>
                                    <x-select-with-hours
                                        label="Hora inicio"
                                        name="''"
                                        :value="$rest->start_time"
                                    />
                                </div>
                                <div class="flex space-x-1 items-center">
                                    <x-select-with-hours
                                        label="Hora fin"
                                        name="''"
                                        :value="$rest->end_time"
                                    />
                                    <a
                                        href="{{ route('employess.break-time.destroy', [$employee, $rest]) }}"
                                        onclick="return confirm('¿Seguro desea eliminar este horario de descanso?');">
                                        <svg class="relative top-3 text-red-600" width="30" height="30" fill="none"
                                             viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="1.5"
                                                  d="M6.75 7.75L7.59115 17.4233C7.68102 18.4568 8.54622 19.25 9.58363 19.25H14.4164C15.4538 19.25 16.319 18.4568 16.4088 17.4233L17.25 7.75"></path>
                                            <path stroke="currentColor" stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="1.5"
                                                  d="M9.75 7.5V6.75C9.75 5.64543 10.6454 4.75 11.75 4.75H12.25C13.3546 4.75 14.25 5.64543 14.25 6.75V7.5"></path>
                                            <path stroke="currentColor" stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="1.5" d="M5 7.75H19"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <div class="flex justify-end py-2">
                            <button
                                type="button"
                                class="inline-flex font-bold items-center px-3 py-0.5 rounded-full text-sm bg-indigo-100 text-indigo-800"
                                onclick="Livewire.emit('openModal', 'create-break-time-livewire', {{ json_encode(["scheduleId" => $schedule->id]) }})">
                                Agregar Descanso
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <x-slot name="footer">
        <x-input.link theme="white" href="{{ route('employees.index') }}">
            Cancelar
        </x-input.link>
        <x-input.button>
            Guardar
        </x-input.button>
    </x-slot>

</x-base-form>
