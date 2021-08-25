<div>
    <div class="py-6 px-8">
        <p class="mb-2 text-lg font-bold text-gray-800">Actualizar localidad</p>
        <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:col-span-2 mt-3">
            <div class="sm:col-span-2">
                <x-input.text
                    label="Nombre"
                    wire:model="form.name"
                    name="form.name"
                />
            </div>
            <div class="sm:col-span-2 mt-4 flex justify-end space-x-2">
                <x-input.button
                    wire:click="closeModal"
                    theme="white">
                    Cancelar
                </x-input.button>
                <x-input.button wire:click="updateLocation">
                    Guardar
                </x-input.button>
            </div>
        </div>
    </div>
</div>
