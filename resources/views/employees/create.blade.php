<x-app-layout header-title="Nuevo Empleado">
    <div class="px-4">
        <div class="mx-auto max-w-7xl">
            <div class="py-4">
                <x-base-form :route="route('employees.store')">
                    <x-input.text
                        name="name"
                        :value="old('name')"
                        label="Nombre"
                    />
                    <x-input.text
                        name="email"
                        :value="old('email')"
                        label="Email"
                    />
                    <x-input.text
                        name="phone"
                        :value="old('phone')"
                        label="Teléfono"
                    />
                    <x-slot name="footer">
                        <x-input.link theme="white" href="{{ route('employees.index') }}">
                            Cancelar
                        </x-input.link>
                        <x-input.button>
                            Guardar
                        </x-input.button>
                    </x-slot>
                </x-base-form>
            </div>
        </div>
    </div>
</x-app-layout>
