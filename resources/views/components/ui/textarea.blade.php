<div>
    @if ($label ?? false)
        <label
            for="{{ $name }}"
            class="block text-sm text-gray-700 {{ $labelBold ? 'font-bold' : '' }}">{{ $label }}</label>
    @endif
    <textarea
        {{ $attributes }}
        id="{{ $name }}"
        name="{{ $name }}"
        rows="2"
        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $value }}</textarea>
    <x-ui.error type="{{ $name }}" />
</div>
