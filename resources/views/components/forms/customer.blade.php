<x-base-form route="{{ $route }}">
    <x-input.text
        name="name"
        label="Nombre"
        value="{{old('name', $customer->name)}}"
    />
    <x-input.text
        name="email"
        label="Correo"
        value="{{old('email', $customer->email)}}"
    />
    <x-input.text
        name="phone"
        label="Teléfono"
        value="{{old('phone', $customer->phone)}}"
    />

    <x-slot name="footer">
        <x-input.link theme="white" href="{{ route('customers.index') }}">
            Cancelar
        </x-input.link>
        <x-input.button>
            Guardar
        </x-input.button>
    </x-slot>
</x-base-form>
