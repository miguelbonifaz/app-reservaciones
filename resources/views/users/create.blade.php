<x-app-layout header-title="Nuevo Usuarios">
    <div class="px-4">
        <div class="mx-auto max-w-7xl">
            <div class="py-4">
                <x-base-form :route="route('users.store')">
                    <x-input.text
                        name="name"
                        label="Nombre"
                    />
                    <x-input.text
                        name="email"
                        label="email"
                    />                
                    <x-input.text
                        name="password"
                        label="Password"
                    />     
                    <x-input.text
                    label="Foto"
                    name="avatar"
                    type="file" />

                    <x-slot name="footer">
                        <x-input.link theme="white" href="{{ route('users.index') }}">
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