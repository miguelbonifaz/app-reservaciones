<div>
    <div class="py-6 px-8">
        <p class="mb-2 text-lg font-bold text-gray-800">Agregar hora de descanso</p>
        <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:col-span-2 mt-3">
            <div>
                <x-input.text
                    label="Hora de inicio"
                    wire:model="restStartTime"
                    name="restStartTime"
                    type="time"
                />
            </div>
            <div>
                <x-input.text
                    label="Hora de salida"
                    wire:model="restEndTime"
                    name="restEndTime"
                    type="time"
                />
            </div>
            <div class="sm:col-span-2 mt-4 flex justify-end space-x-2">
                <x-input.button
                    wire:click="closeModal"
                    theme="white" >
                    Cancelar
                </x-input.button>
                <x-input.button>
                    Guardar
                </x-input.button>
            </div>
        </div>
    </div>
</div>
