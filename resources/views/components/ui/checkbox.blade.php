<div
     class="inline-flex items-center px-4 py-2 mt-1 mb-2 mr-2 space-x-1 rounded-full shadow-sm bg-gray-50">
    <input
        {{ $attributes }}
        id="{{ $label }}_{{ $name }}"
        name="{{ $name }}"
        type="checkbox"
        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
    @if ($label)
        <label for="{{ $label }}_{{ $name }}" class="block ml-2 text-sm text-gray-900">
           {{ $label }}
        </label>
    @endif
</div>
