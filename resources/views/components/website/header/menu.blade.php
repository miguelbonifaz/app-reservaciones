<nav {{ $attributes }}>
    <ul class="flex flex-col space-y-2 text-white">
        <li>
            <a class="inline-block w-full uppercase" href="{{ route('website.home') }}">Inicio</a>
        </li>
        <li>
            <a class="inline-block w-full uppercase" href="">Terapias</a>
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
