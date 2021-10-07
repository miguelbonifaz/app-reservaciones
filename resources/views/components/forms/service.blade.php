<x-base-form route="{{ $route }}">
    <x-input.text
        name="name"
        value="{{ old('name', $service->name) }}"
        label="Nombre"
    />

    <x-input.text
        name="duration"
        value="{{ old('duration', $service->duration) }}"
        label="Duración"
    />

    <x-input.text
        name="value"
        value="{{ old('value', $service->value) }}"
        label="Valor"
    />

    <x-input.text
        name="place"
        value="{{ old('place', $service->place) }}"
        label="Si el servicio es fuera de la oficina, especifique el lugar"
    />

    <x-input.text
        name="slots"
        value="{{ old('slots', $service->slots) }}"
        label="¿Cuantas reservaciones dispone este servicio?"
    />

    <div class="hidden sm:block"></div>

    <div class="sm:col-span-2">
        <x-input.textarea
            label="Descripción"
            name="description"
            value="{{ old('description', $service->description)}}"
        />
    </div>

    <x-slot name="footer">
        <x-input.link theme="white" href="{{ route('services.index') }}">
            Cancelar
        </x-input.link>
        <x-input.button>
            Guardar
        </x-input.button>
    </x-slot>
</x-base-form>
