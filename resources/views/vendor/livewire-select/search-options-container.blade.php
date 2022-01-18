<div
    class="origin-top-left absolute left-0 mt-2 w-full rounded-md shadow-lg z-10"

     x-show="isOpen"
>
    @if(!$emptyOptions)
        <div class="rounded-md bg-white shadow-xs">
            <div class="py-1">
                @foreach($options as $option)
                    @include($searchOptionItem, [
                        'option' => $option,
                        'index' => $loop->index,
                        'styles' => $styles,
                    ])
                @endforeach
            </div>
        </div>
    @elseif ($isSearching)
        <div class="rounded-md bg-white shadow-xs">
            <div class="py-1">
                @include($searchNoResultsView, [
                    'styles' => $styles,
                ])
            </div>
        </div>
    @endif
</div>
