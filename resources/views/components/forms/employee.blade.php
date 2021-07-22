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
            <div class="grid gap-1.5 md:grid-cols-2">
                @foreach ($employee->schedules as $schedule)
                    <div class="py-2 px-4 mt-1 mr-2 mb-2 space-y-1 bg-gray-50 rounded-lg shadow-sm">
                        <div>
                            <label for="monday" class="block mb-1 ml-2 font-semibold text-gray-800">
                                {{ $schedule->present()->dayOfWeek() }}
                            </label>
                        </div>
                        <div class="sm:grid sm:grid-cols-2 sm:gap-2">
                            <div>
                                <x-input.text
                                    label="Hora de inicio"
                                    name="start_time[{{ $schedule->day }}]"
                                    type="time"
                                    value="{{ $schedule->start_time }}"
                                />
                            </div>
                            <div>
                                <x-input.text
                                    label="Hora de salida"
                                    name="end_time[{{ $schedule->day }}]"
                                    type="time"
                                    value="{{$schedule->end_time }}"
                                />
                            </div>
                        </div>
                        <div class="flex justify-end py-2">
                            <button
                                type="button"
                                class="inline-flex font-bold items-center px-3 py-0.5 rounded-full text-sm bg-indigo-100 text-indigo-800"
                                onclick="Livewire.emit('openModal', 'create-break-time-livewire')">
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
