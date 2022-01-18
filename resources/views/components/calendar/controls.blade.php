@props(['back', 'next', 'current'])
<div class="flex items-end justify-center order-1 mb-3 lg:order-0 lg:mb-0">
    <div class="mr-2 inline-flex border rounded-md shadow-sm">
        <button type="submit"
                wire:click="{{$back}}"
                class="'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
        </button>
    </div>
    <div class="inline-flex rounded-md shadow-sm">
        <button type="submit"
                wire:click="{{$current}}"
                class="'inline-flex items-center px-4 py-3 bg-gray-800 border border-transparent rounded-md text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'">
            {{$slot}}
        </button>
    </div>
    <div class="ml-2 inline-flex rounded-md shadow-sm">
        <button type="submit"
                wire:click="{{$next}}"
                class="'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
        </button>
    </div>
</div>