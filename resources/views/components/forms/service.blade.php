<x-base-form route="{{ $route }}">
    <x-input.text
        name="name"
        value="{{old('name', $service->name)}}"
        label="Nombre"
    />

    <x-input.text
        name="duration"
        value="{{old('duration', $service->duration)}}"
        label="Duración"
    />

    <x-slot name="footer">
        <x-input.link theme="white" href="{{ route('services.index') }}">
            Cancelar
        </x-input.link>
        <x-input.button>
            Guardar
        </x-input.button>
    </x-slot>
</x-base-form>
