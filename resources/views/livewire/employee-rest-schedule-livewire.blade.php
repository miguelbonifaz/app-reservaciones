<div class="sm:col-span-2">
    <x-base>
        <div class="flex justify-start space-x-2 sm:col-span-2">
            <button type="button" wire:click="addRest"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 ">
                Agregar descanso.
            </button>
        </div>

        @foreach ($this->rests as $uuid)
            <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:col-span-2" wire:key="{{ \Illuminate\Support\Str::uuid() }}">
                <div>
                    <x-input.text
                        label="Hora de inicio"
                        name="restStartTime[{{ $this->day }}][]"
                        type="time"
                    />
                </div>
                <div>
                    <x-input.text
                        label="Hora de salida"
                        name="restEndtTime[{{ $this->day }}][]"
                        type="time"
                    />
                </div>
            </div>
        @endforeach
    </x-base>
</div>
