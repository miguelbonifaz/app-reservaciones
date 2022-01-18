<div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <img class="w-8 h-8" src="https://tailwindui.com/img/logos/workflow-mark-indigo-300.svg"
                     alt="Workflow">
            </div>
            <div class="hidden md:block">
                <div class="flex items-baseline ml-10 space-x-4">
                    @foreach ($menu as $m)
                        <a
                            href="{{ $m['route'] }}"
                            @if ($m['isActive'])
                            class="py-2 px-3 text-sm font-medium text-white bg-indigo-700 rounded-md"
                            @else
                            class="py-2 px-3 text-sm font-medium text-white rounded-md hover:bg-indigo-500 hover:bg-opacity-75"
                            @endif
                        >
                            {{ $m['title'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="hidden md:block">
            <div class="flex items-center ml-4 md:ml-6">
                <button
                    class="p-1 bg-indigo-600 rounded-full text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white">
                    <span class="sr-only">View notifications</span>
                    <!-- Heroicon name: outline/bell -->
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>

                <!-- Profile dropdown -->
                <div class="relative ml-3">
                    <div>
                        <button
                            x-on:click="profile = !profile"
                            x-on:click.away="profile = false"
                            type="button"
                            class="flex items-center max-w-xs text-sm text-white bg-gray-800 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 object-cover rounded-full"
                                 src="{{ auth()->user()->present()->avatarUrl() }}"
                                 alt="{{ auth()->user()->present()->name() }}">
                        </button>
                    </div>
                    <div
                        x-cloak
                        x-show="profile"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 py-1 mt-2 w-48 bg-white rounded-md ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                        tabindex="-1">
                        <a href="{{ route('profile.edit', ['user' => auth()->user(),'redirectUrl' => url()->full()]) }}"
                           class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100"
                           role="menuitem" tabindex="-1"
                           id="user-menu-item-0">Tu Perfil</a>
                        <form action="{{route('logout')}}"
                              method="post">
                            @csrf
                            <a class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100"
                               role="menuitem" tabindex="-1"
                               id="user-menu-item-0">
                                <button type="submit">
                                    Cerrar Sesión
                                </button>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex -mr-2 md:hidden">
            <!-- Mobile menu button -->
            <button
                x-on:click="menu = !menu"
                x-on:click.away="menu = false"
                type="button"
                class="bg-indigo-600 inline-flex items-center justify-center p-2 rounded-md text-indigo-200 hover:text-white hover:bg-indigo-500 hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white"
                aria-controls="mobile-menu" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <!--
                  Heroicon name: outline/menu

                  Menu open: "hidden", Menu closed: "block"
                -->
                <svg x-show="!menu" class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <!--
                  Heroicon name: outline/x

                  Menu open: "block", Menu closed: "hidden"
                -->
                <svg x-cloak x-show="menu" class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>
