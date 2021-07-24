<div>
    <div class="py-6 px-8">
        <p class="mb-2 text-lg font-bold text-gray-800">Agregar hora de descanso</p>
        <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:col-span-2 mt-3">
            <div>
                <x-select-with-hours
                    label="Hora inicio"
                    wire:model="startTime"
                    name="startTime"
                />
            </div>
            <div>
                <x-select-with-hours
                    label="Hora fin"
                    wire:model="endTime"
                    name="endTime"
                />
            </div>
            <div class="sm:col-span-2 mt-4 flex justify-end space-x-2">
                <x-input.button
                    wire:click="closeModal"
                    theme="white">
                    Cancelar
                </x-input.button>
                <x-input.button wire:click="createBreakTime">
                    Guardar
                </x-input.button>
            </div>
        </div>
    </div>
</div>
