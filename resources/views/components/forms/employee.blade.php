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
            <div class="inline-flex items-center px-4 py-2 mt-1 mb-2 mr-2 space-x-1 rounded-full shadow-sm bg-gray-50">
                <input
                    {{ collect(old('servicesId', $employee->services->pluck('id')))->contains($service->id) ? 'checked' : '' }}
                    id="service_{{ $service->id }}"
                    name="servicesId[]"
                    value="{{ $service->id }}"
                    type="checkbox"
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label
                    for="service_{{ $service->id }}"
                    class="block ml-2 text-sm text-gray-900">
                    {{ $service->present()->name() }}
                </label>
            </div>
        @endforeach
    </div>
    @if (count($daysOfWeek))
        <div class="sm:col-span-2">
            <p class="mb-2 text-lg font-bold text-gray-800">Horario de trabajo</p>
            <div class="grid gap-1.5 md:grid-cols-2">
                @foreach ($daysOfWeek as $key => $value)
                    <div class="py-2 px-4 mt-1 mr-2 mb-2 space-y-1 bg-gray-50 rounded-lg shadow-sm">
                        <div>
                            <label for="monday" class="block mb-1 ml-2 font-semibold text-gray-800">
                                {{ $value }}
                            </label>
                        </div>
                        <div class="sm:grid sm:grid-cols-2 sm:gap-2">
                            <div>
                                <x-input.text
                                    label="Hora de inicio"
                                    name="start_time[{{ $key }}]"
                                    type="time"
                                    value="{{ $employee->schedules->firstWhere('day',$key)->start_time }}"
                                />
                            </div>
                            <div>
                                <x-input.text
                                    label="Hora de salida"
                                    name="end_time[{{ $key }}]"
                                    type="time"
                                    value="{{$employee->schedules->firstWhere('day',$key)->end_time }}"
                                />
                            </div>
                        </div>

                        <livewire:employee-rest-schedule-livewire
                            day="{{ $key }}"
                        />
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
