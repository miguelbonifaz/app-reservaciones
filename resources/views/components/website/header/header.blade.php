<header
    class="py-7 px-6 w-full {{ $withBackground ? 'bg-mariajose_gray' : 'absolute top-0 w-full bg-mariajose_gray lg:bg-transparent' }}"
    x-data="{ open: false }">
    <div class="lg:max-w-7xl lg:mx-auto">
        <div class="flex justify-between items-center">
            <figure>
                <h1 class="text-xl font-bold text-white">Psicóloga María José Jáuregui</h1>
            </figure>
            <svg
                x-on:click="open = !open"
                x-on:click.away="open = false"
                class="text-white lg:hidden"
                width="27"
                height="27"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M4.75 5.75H19.25"></path>
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M4.75 18.25H19.25"></path>
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M4.75 12H19.25"></path>
            </svg>
            <nav class="hidden lg:block">
                <ul class="flex space-x-8 text-white">
                    <li>
                        <a class="inline-block w-full text-sm font-bold uppercase testing"
                           href="{{ route('website.home') }}">Inicio</a>
                    </li>
                    <li>
                        <a class="inline-block w-full text-sm font-bold uppercase testing" href="{{ route('website.therapy') }}">Terapias</a>
                    </li>
                    <li>
                        <a class="inline-block w-full text-sm font-bold uppercase testing" href="">Evaluaciones</a>
                    </li>
                    <li>
                        <a class="inline-block w-full text-sm font-bold uppercase testing"
                           href="{{ route('website.reservation') }}">Reservaciones</a>
                    </li>
                    <li>
                        <a class="inline-block w-full text-sm font-bold uppercase testing" href="{{ route('website.contact') }}">Contacto</a>
                    </li>
                </ul>
            </nav>
        </div>
        <nav class="mt-2 lg:hidden" x-show="open" x-cloak>
            <ul class="flex flex-col space-y-2 text-white">
                <li>
                    <a class="inline-block w-full uppercase" href="{{ route('website.home') }}">Inicio</a>
                </li>
                <li>
                    <a class="inline-block w-full uppercase" href="">Terapias</a>
                </li>
                <li>
                    <a class="inline-block w-full uppercase" href="">Evaluaciones</a>
                </li>
                <li>
                    <a class="inline-block w-full uppercase"
                       href="{{ route('website.reservation') }}">Reservaciones</a>
                </li>
                <li>
                    <a class="inline-block w-full uppercase" href="">Contacto</a>
                </li>
            </ul>
        </nav>
    </div>
</header>
