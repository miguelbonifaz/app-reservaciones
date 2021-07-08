<div>
    @if ($label)
        <label
            for="{{ $name }}"
            class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
    <select
        {{ $attributes }}
        id="{{ $name }}"
        name="{{ $name }}"
        class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        <option value="">Escoja una opción...</option>
        {{ $slot }}
    </select>

    <x-input.error :type="$name"/>
</div>
