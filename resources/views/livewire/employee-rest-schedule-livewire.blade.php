<div>
    <x-base>
        <div class="flex justify-start space-x-2">            
                <button type="button" wire:click="addRest"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 ">
                    Agregar descanso.
                </button>      
        </div>
        <div></div>                
        @if ($rests)                        
        {{ dd(collect([$scheduleId => $rests]))}}
            @foreach (collect([$scheduleId => $rests]) as $index => $rest) {{-- key para eliminar --}}               
            <div class="sm:grid sm:grid-cols-2 sm:gap-2">                                
                <div>
                    <x-input.text
                        {{-- wire:model="restStartTime[{{ $index }}]" --}}
                        label="Hora de inicio"
                        name="restStartTime[{{ $index }}]"
                        type="time"
                        {{-- value="{{ $employee->schedules->firstWhere('day',$key)->start_time }}" --}}
                    />
                </div>
                <div>
                    <x-input.text
                        {{-- wire:model="restEndtTime[{{ $index }}]" --}}
                        label="Hora de salida"
                        name="restEndtTime[{{ $index }}"
                        type="time"
                        {{-- value="{{$employee->schedules->firstWhere('day',$key)->end_time }}" --}}
                    />
                </div>
            </div>
            @endforeach
        @endif
    </x-base>
</div>