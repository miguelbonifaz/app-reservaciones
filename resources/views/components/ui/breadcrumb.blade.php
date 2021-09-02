<nav class="flex" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        @foreach ($breadcrumb as $item)
            <li>
                <div class="flex items-center">
                    @if ($loop->index)
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                    @endif
                    <a href="{{ $item['url'] }}" class="{{ $loop->index ? 'ml-4' : '' }} text-sm font-medium text-gray-500 hover:text-gray-700">{{ $item['title'] }}</a>
                </div>
            </li>
        @endforeach
    </ol>
</nav>