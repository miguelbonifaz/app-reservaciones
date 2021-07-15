<x-base-form route="{{ $route }}">
    <div class="sm:col-span-2">
        <p class="mb-2 text-lg font-bold text-gray-800">Información</p>
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
    <div></div>
    <div class="flex items-center h-5">
        <x-input.select
            name="service"
            label="Escoja un servicio">
            @foreach($services as $service)
                <option
                    {{ old('service'/* , $employee->services->first()->id */) /* == $service->id ? 'selected' : ''  */}}
                    value="{{ $service->id }}">{{ $service->present()->name() }}
                </option>
            @endforeach
        </x-input.select>
        @foreach($services as $service)
            <x-input
        @endforeach

    <x-slot name="footer">
        <x-input.link theme="white" href="{{ route('employees.index') }}">
            Cancelar
        </x-input.link>
        <x-input.button>
            Guardar
        </x-input.button>
    </x-slot>

    <hr class="border-t border-gray-200 sm:col-span-2">

    <div class="sm:col-span-2">
        <p class="mb-2 text-lg font-bold text-gray-800">Asignación de servicios</p>
        <x-input.checkbox
            label="Servicio 1"
            value="1"
            name="servicesId[]"
        />
        <x-input.checkbox
            label="Servicio 2"
            value="2"
            name="servicesId[]"
        />
        <x-input.checkbox
            label="Servicio 3"
            value="3"
            name="servicesId[]"
        />
    </div>

    <div class="sm:col-span-2">
        <p class="mb-2 text-lg font-bold text-gray-800">Horario de trabajo</p>
        <div class="grid gap-1.5 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($daysOfWeek as $key => $value)
                <div class="py-2 px-4 mt-1 mr-2 mb-2 space-y-1 bg-gray-50 rounded-lg shadow-sm">
                        <div>
                            <div>
                                <label for="monday" class="block mb-1 ml-2 font-semibold text-gray-800">
                                    {{ $value }}
                                </label>
                            </div>
                            <div class="sm:grid sm:grid-cols-2 sm:gap-2">
                                <x-input.select placeholder="Hora de inicio" name="start_time">
                                    <option value="">09:30</option>
                                    <option value="">10:00</option>
                                    <option value="">10:30</option>
                                </x-input.select>
                                <x-input.select placeholder="Hora de salida" name="end_time">
                                    <option value="">09:30</option>
                                    <option value="">10:00</option>
                                    <option value="">10:30</option>
                                </x-input.select>
                            </div>
                        </div>
                </div>
            @endforeach
        </div>
    </div>
</x-base-form>
