<div>
    <div>
        @if ($label)
            <label
                for="{{ $name }}"
                class="block text-sm text-left text-gray-700 {{ $labelBold ? 'font-bold' : '' }}">{{ $label }}</label>
        @endif
        <input
            {{ $attributes }}
            placeholder="{{ $placeholder }}"
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $value }}"
            autocomplete="off"
            class="block w-full mt-1 border-gray-300 shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @if($type == 'file') p-2 @endif">
        <x-input.error :type="$name"/>
    </div>
</div>
