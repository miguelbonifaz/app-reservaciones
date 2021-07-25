<header class="bg-mariajose_gray py-7 container px-6" x-data="{ open: false }">
    <div class="flex  justify-between items-center">
        <figure>
            <h1 class="font-bold text-white text-xl">Psicóloga María José Jáuregui</h1>
        </figure>
        <svg
            x-on:click="open = !open"
            x-on:click.away="open = false"
            class="text-white"
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

    </div>
    <nav class="mt-2" x-show="open" x-cloak>
        <ul class="flex flex-col text-white space-y-2">
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
</header>
