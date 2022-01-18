<div class="md:hidden" id="mobile-menu" x-cloak x-show="menu">
    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        @foreach ($menu as $m)
            <a
                href="{{ $m['route'] }}"
                @if ($m['isActive'])
                    class="block py-2 px-3 text-base font-medium text-white bg-indigo-700 rounded-md"
                @else
                    class="block py-2 px-3 text-base font-medium text-white rounded-md hover:bg-indigo-500 hover:bg-opacity-75"
                @endif
            >
                {{ $m['title'] }}
            </a>
        @endforeach
    </div>
    <div class="pt-4 pb-3 border-t border-indigo-700">
        <div class="flex items-center px-5">
            <div class="flex-shrink-0">
                <img class="w-10 h-10 rounded-full"
                     src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                     alt="">
            </div>
            <div class="ml-3">
                <div class="text-base font-medium text-white">Tom Cook</div>
                <div class="text-sm font-medium text-indigo-300">tom@example.com</div>
            </div>
            <button
                class="flex-shrink-0 p-1 ml-auto text-indigo-200 bg-indigo-600 rounded-full hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white">
                <span class="sr-only">View notifications</span>
                <!-- Heroicon name: outline/bell -->
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </button>
        </div>
        <div class="px-2 mt-3 space-y-1">
            <a href="#"
               class="block py-2 px-3 text-base font-medium text-white rounded-md hover:bg-indigo-500 hover:bg-opacity-75">Tu Perfil</a>
        </div>
    </div>
</div>
