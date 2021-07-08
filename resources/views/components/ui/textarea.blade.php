<div>
    @if ($label ?? false)
        <label
            for="{{ $name }}"
            class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
    <textarea
        {{ $attributes }}
        id="{{ $name }}"
        name="{{ $name }}"
        rows="2"
        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $value }}</textarea>
    <x-ui.error type="{{ $name }}" />
</div>
