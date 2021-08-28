<div>
    <div class="py-6 px-8">
        <p class="mb-2 text-lg font-bold text-gray-800">Asignación de localidad</p>
        <x-input.select
            wire:model="locationId"
            name="locationId"
            placeholder="Escoje un local">
            @foreach ($this->locations as $location)
                <option value="{{ $location->id }}">{{ $location->present()->name() }}</option>
            @endforeach
        </x-input.select>
        <div class="sm:col-span-2 mt-4 flex justify-end space-x-2">
            <x-input.button
                wire:click="closeModal"
                theme="white">
                Cancelar
            </x-input.button>
            <x-input.button wire:click="assignLocation">
                Guardar
            </x-input.button>
        </div>
    </div>
</div>
