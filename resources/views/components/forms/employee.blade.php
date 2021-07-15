<x-base-form route="{{ $route }}">
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
        {{-- @foreach ($services as $services)
                  
            <input id="services" name="{{ $service->id }}[]"
            value="{{ $service->id }}"
            type="checkbox"
            class="w-4 h-4 mx-3 text-indigo-600 border-gray-300 cursor-pointer check focus:ring-indigo-500" >
                <span class="block font-medium text-md justify-items-start">
                    {{ $service->present()->name() }}
                </span>
        </div>
    @endforeach --}}

    <x-slot name="footer">
        <x-input.link theme="white" href="{{ route('employees.index') }}">
            Cancelar
        </x-input.link>
        <x-input.button>
            Guardar
        </x-input.button>
    </x-slot>
</x-base-form>
