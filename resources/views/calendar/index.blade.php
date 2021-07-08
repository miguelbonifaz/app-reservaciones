<x-app-layout header-title="Calendario">

    <x-base-form route="aqui-va-la-ruta">
        <x-input.text
            name="name"
            label="Nombre"
        />
        <x-input.select
            name="city"
            label="Escoja una ciudad">
            @foreach([] as $item)
                <option value="">Aqui vas las opciones</option>
            @endforeach
        </x-input.select>
        <x-input.textarea
            label="Textarea"
            name="name"
            value="testing"
        />
        <x-slot name="footer">
            <x-input.link theme="white" href="{{ route('calendar.index') }}">
                Cancelar
            </x-input.link>
            <x-input.button>
                Guardar
            </x-input.button>
        </x-slot>
    </x-base-form>

</x-app-layout>
