<x-app-layout header-title="{{ $employee->present()->name() }}">    
    <div class="px-4">        
        <div class="mx-auto max-w-7xl">
            <div class="py-4">                
                <x-base-form :route="route('employees.update',$employee)">
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
