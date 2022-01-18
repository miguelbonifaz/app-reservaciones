<div
    class="cursor-pointer block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900"

    wire:click.stop="selectValue('{{ $option['value'] }}')"

    x-bind:class="{ 'bg-gray-100': selectedIndex === {{ $index }} }"
    x-on:mouseover="selectedIndex = {{ $index }}"
>
    {{ $option['description'] }}
</div>
