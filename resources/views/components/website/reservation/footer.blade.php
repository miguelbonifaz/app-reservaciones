<div class="border-t border-gray-200 lg:mt-4 sm:col-span-2">
    <div class="flex justify-between mt-8">
        @if ($stepBack ?? false)
            <button
                wire:click="stepBack('{{ $stepBack[0] }}', {{ $stepBack[1] }})"
                type="button"
                class="inline-flex justify-center items-center py-2 pr-4 pl-2 font-bold leading-4 text-white rounded-md border border-transparent shadow-sm text-md bg-mariajose_gray hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg
                    class="w-6 h-6 relative" style="top: 1px" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                          clip-rule="evenodd"></path>
                </svg>
                Atras
            </button>
        @else
            <div></div>
        @endif
        @if ($nextStep ?? false)
            <button
                type="button"
                wire:click="nextStep('{{ $nextStep }}')"
                class="inline-flex justify-center items-center py-2 pr-2 pl-4 font-bold leading-4 text-white rounded-md border border-transparent shadow-sm text-md bg-mariajose_gray hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Siguiente
                <svg class="w-6 h-6 relative" style="top: 1px" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                          clip-rule="evenodd"></path>
                </svg>
            </button>
        @else
            <div></div>
        @endif
    </div>
</div>
