<x-website-layout>
    <x-website.header.header :with-background="false"/>
    <header>
        <figure></figure>
    </header>
    <section
        class="flex flex-col justify-center h-screen bg-center"
        style="background: url({{ asset('assets/home/hero_image.jpg') }})">
        <div class="px-6 mx-auto max-w-7xl text-center">
            <h1 class="mb-6 text-3xl font-bold text-white lg:text-6xl lg:mb-14">Máster en Autismo e <br> Intervención
                Psicoeducativa</h1>
            <a
                href="{{ route('website.reservation') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-bold text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 lg:text-lg focus:ring-offset-2 focus:ring-indigo-500">
                REALIZA TU CITA ONLINE
                <svg
                    class="ml-2 w-2"
                    width="10"
                    height="17" viewBox="0 0 10 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M9.63867 9.50586C9.97266 9.17188 9.97266 8.61523 9.63867 8.28125L2.43945 1.04492C2.06836 0.710938 1.51172 0.710938 1.17773 1.04492L0.324219 1.89844C-0.00976562 2.23242 -0.00976562 2.78906 0.324219 3.16016L6.03906 8.875L0.324219 14.627C-0.00976562 14.998 -0.00976562 15.5547 0.324219 15.8887L1.17773 16.7422C1.51172 17.0762 2.06836 17.0762 2.43945 16.7422L9.63867 9.50586Z"
                        fill="#373737"/>
                </svg>

            </a>
        </div>
    </section>
    <section class="pt-10 pb-36 bg-center bg-cover"
             style="background-image: url({{ asset('assets/home/bg-tracyectoria.jpg') }})">
        <div class="px-6 mx-auto max-w-7xl lg:max-w-4xl">
            <h3 class="title_large">Trayectoria / curriculum</h3>
            <div class="md:flex">
                <div class="mb-10 md:w-1/2">
                    <figure class="flex justify-center">
                        <img class="w-72 lg:w-10/12" src="{{ asset('assets/home/maria-jose-jauregui.png') }}"
                             alt="Psicóloga María José Jáuregui">
                    </figure>
                </div>
                <div class="md:w-1/2">
                    <p>Psicóloga Clínica
                        Máster en Autismo e Intervención Psicoeducativa
                        Especializada en España y Argentina
                        Especialista en Comunicación y Socialización
                        Asesora de Universidades, Fasinarm y diferentes instituciones en temas de Autismo
                        Calificadora del carnet del Conadis
                        Psicóloga Clínica encargada del proyecto gubernamental Gallegos Lara
                        Certificación en método Pierce al entorno escolar para mejorar habilidades sociales de niños y
                        adolescentes con trastornos del espectro autista y otros desafíos sociales (Universidad de
                        California UCLA)
                    </p>
                    <h5 class="mt-10 mb-4 text-2xl uppercase">Redes sociales</h5>
                    <div class="flex space-x-6">
                        <a href="">
                            <svg
                                width="27"
                                height="27"
                                viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M23.4375 0.625H2.8125C1.23047 0.625 0 1.91406 0 3.4375V24.0625C0 25.6445 1.23047 26.875 2.8125 26.875H10.8398V17.9688H7.14844V13.75H10.8398V10.5859C10.8398 6.95312 13.0078 4.90234 16.2891 4.90234C17.9297 4.90234 19.5703 5.19531 19.5703 5.19531V8.76953H17.7539C15.9375 8.76953 15.3516 9.88281 15.3516 11.0547V13.75H19.3945L18.75 17.9688H15.3516V26.875H23.4375C24.9609 26.875 26.25 25.6445 26.25 24.0625V3.4375C26.25 1.91406 24.9609 0.625 23.4375 0.625Z"
                                    fill="#373737"/>
                            </svg>
                        </a>
                        <a href="">
                            <svg
                                width="28"
                                height="27"
                                viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.125 7.01172C10.375 7.01172 7.38672 10.0586 7.38672 13.75C7.38672 17.5 10.375 20.4883 14.125 20.4883C17.8164 20.4883 20.8633 17.5 20.8633 13.75C20.8633 10.0586 17.8164 7.01172 14.125 7.01172ZM14.125 18.1445C11.7227 18.1445 9.73047 16.2109 9.73047 13.75C9.73047 11.3477 11.6641 9.41406 14.125 9.41406C16.5273 9.41406 18.4609 11.3477 18.4609 13.75C18.4609 16.2109 16.5273 18.1445 14.125 18.1445ZM22.6797 6.77734C22.6797 5.89844 21.9766 5.19531 21.0977 5.19531C20.2188 5.19531 19.5156 5.89844 19.5156 6.77734C19.5156 7.65625 20.2188 8.35938 21.0977 8.35938C21.9766 8.35938 22.6797 7.65625 22.6797 6.77734ZM27.1328 8.35938C27.0156 6.25 26.5469 4.375 25.0234 2.85156C23.5 1.32812 21.625 0.859375 19.5156 0.742188C17.3477 0.625 10.8438 0.625 8.67578 0.742188C6.56641 0.859375 4.75 1.32812 3.16797 2.85156C1.64453 4.375 1.17578 6.25 1.05859 8.35938C0.941406 10.5273 0.941406 17.0312 1.05859 19.1992C1.17578 21.3086 1.64453 23.125 3.16797 24.707C4.75 26.2305 6.56641 26.6992 8.67578 26.8164C10.8438 26.9336 17.3477 26.9336 19.5156 26.8164C21.625 26.6992 23.5 26.2305 25.0234 24.707C26.5469 23.125 27.0156 21.3086 27.1328 19.1992C27.25 17.0312 27.25 10.5273 27.1328 8.35938ZM24.3203 21.4844C23.9102 22.6562 22.9727 23.5352 21.8594 24.0039C20.1016 24.707 16 24.5312 14.125 24.5312C12.1914 24.5312 8.08984 24.707 6.39062 24.0039C5.21875 23.5352 4.33984 22.6562 3.87109 21.4844C3.16797 19.7852 3.34375 15.6836 3.34375 13.75C3.34375 11.875 3.16797 7.77344 3.87109 6.01562C4.33984 4.90234 5.21875 4.02344 6.39062 3.55469C8.08984 2.85156 12.1914 3.02734 14.125 3.02734C16 3.02734 20.1016 2.85156 21.8594 3.55469C22.9727 3.96484 23.8516 4.90234 24.3203 6.01562C25.0234 7.77344 24.8477 11.875 24.8477 13.75C24.8477 15.6836 25.0234 19.7852 24.3203 21.4844Z"
                                    fill="#373737"/>
                            </svg>
                        </a>
                        <a href="">
                            <svg
                                width="30"
                                height="25"
                                viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M26.8945 6.65625C28.0664 5.77734 29.1211 4.72266 29.9414 3.49219C28.8867 3.96094 27.6562 4.3125 26.4258 4.42969C27.7148 3.66797 28.6523 2.49609 29.1211 1.03125C27.9492 1.73438 26.6016 2.26172 25.2539 2.55469C24.082 1.32422 22.5 0.621094 20.7422 0.621094C17.3438 0.621094 14.5898 3.375 14.5898 6.77344C14.5898 7.24219 14.6484 7.71094 14.7656 8.17969C9.66797 7.88672 5.09766 5.42578 2.05078 1.73438C1.52344 2.61328 1.23047 3.66797 1.23047 4.83984C1.23047 6.94922 2.28516 8.82422 3.98438 9.9375C2.98828 9.87891 1.99219 9.64453 1.17188 9.17578V9.23438C1.17188 12.2227 3.28125 14.6836 6.09375 15.2695C5.625 15.3867 5.03906 15.5039 4.51172 15.5039C4.10156 15.5039 3.75 15.4453 3.33984 15.3867C4.10156 17.8477 6.38672 19.6055 9.08203 19.6641C6.97266 21.3047 4.33594 22.3008 1.46484 22.3008C0.9375 22.3008 0.46875 22.2422 0 22.1836C2.69531 23.9414 5.91797 24.9375 9.43359 24.9375C20.7422 24.9375 26.8945 15.6211 26.8945 7.47656C26.8945 7.18359 26.8945 6.94922 26.8945 6.65625Z"
                                    fill="#373737"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16" style="background-image: url({{ asset('assets/home/bg-horario-de-atencion.jpg') }})">
        <x-website.container>
            <h3 class="title_large">Horario de atención</h3>
            <div class="lg:flex">
                <div class="mb-8 divide-y-2 divide-gray-200 lg:w-5/12 lg:pr-10">
                    <div class="py-4">
                        <h4 class="mb-3 text-xl font-bold uppercase text-mariajose_gray lg:text-2xl">Lunes a
                            Viernes</h4>
                        <div class="flex items-baseline">
                            <svg
                                class="self-center mr-2"
                                width="20"
                                height="21"
                                viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 0.8125C4.64844 0.8125 0.3125 5.14844 0.3125 10.5C0.3125 15.8516 4.64844 20.1875 10 20.1875C15.3516 20.1875 19.6875 15.8516 19.6875 10.5C19.6875 5.14844 15.3516 0.8125 10 0.8125ZM18.4375 10.5C18.4375 15.1484 14.6484 18.9375 10 18.9375C5.35156 18.9375 1.5625 15.1875 1.5625 10.5C1.5625 5.89062 5.3125 2.0625 10 2.0625C14.6094 2.0625 18.4375 5.85156 18.4375 10.5ZM12.6172 13.9766C12.8125 14.1328 13.125 14.0547 13.2422 13.8594L13.5938 13.4297C13.75 13.1953 13.6719 12.9219 13.4766 12.7656L10.7422 10.7734V5.03125C10.7422 4.79688 10.5078 4.5625 10.2734 4.5625H9.72656C9.45312 4.5625 9.25781 4.79688 9.25781 5.03125V11.2812C9.25781 11.4375 9.29688 11.5547 9.41406 11.6719L12.6172 13.9766Z"
                                    fill="#373737"/>
                            </svg>
                            <p>A partir desde las 8am a 5pm</p>
                        </div>
                    </div>
                    <div class="py-4">
                        <h4 class="mb-3 text-xl font-bold uppercase text-mariajose_gray lg:text-2xl">Ubicación</h4>
                        <div class="flex items-baseline">
                            <svg
                                class="self-center mr-2"
                                width="15"
                                height="21"
                                viewBox="0 0 15 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.5 4.25C5.42969 4.25 3.75 5.96875 3.75 8C3.75 10.0703 5.42969 11.75 7.5 11.75C9.53125 11.75 11.25 10.0703 11.25 8C11.25 5.96875 9.53125 4.25 7.5 4.25ZM7.5 10.5C6.09375 10.5 5 9.40625 5 8C5 6.63281 6.09375 5.5 7.5 5.5C8.86719 5.5 10 6.63281 10 8C10 9.40625 8.86719 10.5 7.5 10.5ZM7.5 0.5C3.32031 0.5 0 3.85938 0 8C0 11.0469 1.01562 11.9062 6.71875 20.1094C7.07031 20.6562 7.89062 20.6562 8.24219 20.1094C13.9453 11.9062 15 11.0469 15 8C15 3.85938 11.6406 0.5 7.5 0.5ZM7.5 19.0156C2.03125 11.1641 1.25 10.5391 1.25 8C1.25 6.35938 1.875 4.79688 3.04688 3.58594C4.25781 2.41406 5.82031 1.75 7.5 1.75C9.14062 1.75 10.7031 2.41406 11.9141 3.58594C13.0859 4.79688 13.75 6.35938 13.75 8C13.75 10.5391 12.9297 11.1641 7.5 19.0156Z"
                                    fill="#373737"/>
                            </svg>
                            <p>Edificio Xima piso 2km 2 vía Samborondon</p>
                        </div>
                    </div>
                    <div class="py-4">
                        <h4 class="mb-3 text-xl font-bold uppercase text-mariajose_gray lg:text-2xl">Email</h4>
                        <div class="flex items-baseline">
                            <svg
                                class="self-center mr-2"
                                width="20"
                                height="15"
                                viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.125 0H1.875C0.820312 0 0 0.859375 0 1.875V13.125C0 14.1797 0.820312 15 1.875 15H18.125C19.1406 15 20 14.1797 20 13.125V1.875C20 0.859375 19.1406 0 18.125 0ZM1.875 1.25H18.125C18.4375 1.25 18.75 1.5625 18.75 1.875V3.51562C17.8906 4.21875 16.6406 5.23438 12.8516 8.24219C12.1875 8.78906 10.8984 10.0391 10 10C9.0625 10.0391 7.77344 8.78906 7.10938 8.24219C3.32031 5.23438 2.07031 4.21875 1.25 3.51562V1.875C1.25 1.5625 1.52344 1.25 1.875 1.25ZM18.125 13.75H1.875C1.52344 13.75 1.25 13.4766 1.25 13.125V5.11719C2.10938 5.85938 3.51562 6.99219 6.32812 9.21875C7.14844 9.88281 8.55469 11.2891 10 11.25C11.4062 11.2891 12.8125 9.88281 13.6328 9.21875C16.4453 6.99219 17.8516 5.85938 18.75 5.11719V13.125C18.75 13.4766 18.4375 13.75 18.125 13.75Z"
                                    fill="#373737"/>
                            </svg>
                            <p>majo_jauregui@hotmail.com</p>
                        </div>
                    </div>
                </div>
                <div class="lg:flex-grow">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.038962214493!2d-79.86788898524492!3d-2.1387426984409807!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x902d6ce50485c9c5%3A0x482084f5ddf95691!2sEdificio%20Xima%2C%20Samborond%C3%B3n%20092301!5e0!3m2!1ses-419!2sec!4v1631066772056!5m2!1ses-419!2sec"
                        width="100%"
                        height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"></iframe>
                </div>
            </div>
        </x-website.container>
    </section>
    <section class="py-16">
        <x-website.container>
            <h3 class="title_large">Servicios</h3>
            <div class="flex flex-col">
                <div class="overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 font-bold tracking-wider text-left text-gray-800 uppercase">
                                        Servicio
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 font-bold tracking-wider text-left text-gray-800 uppercase">
                                        Lugar
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 font-bold tracking-wider text-left text-gray-800 uppercase">
                                        Valor
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 font-bold tracking-wider text-left text-gray-800 uppercase">
                                        Tiempo duración
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="bg-white">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Reunión en escuela
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        Escuela
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        $100
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        1 hora
                                    </td>
                                </tr>
                                <tr class="bg-white">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Observación en escuela
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        Escuela
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        $100
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        1 hora
                                    </td>
                                </tr>
                                <tr class="bg-white">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Observación en casa
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        Casa
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        $120
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        1 hora y media
                                    </td>
                                </tr>
                                <tr class="bg-white">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Reunión con profesionales externos
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        Oficina Samborondón
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        $90
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        45 minutos
                                    </td>
                                </tr>
                                <tr class="bg-white">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Intervención individual
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        Oficina Samborondón
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        $40
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        45 minutos
                                    </td>
                                </tr>
                                <tr class="bg-white">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Terapia Lúdico
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        Consultar lugar
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        $55
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        1 hora y media
                                    </td>
                                </tr>
                                <tr class="bg-white">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Reunión con padres
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        Oficina Samborondón
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        $90
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        1 hora
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </x-website.container>
    </section>
    <section class="py-16">
        <x-website.container>
            <h3 class="title_large">Conoce Nuestras Oficinas</h3>
            <p class="mb-12 text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                incididunt ut labore et
                dolore magna aliqua.
            </p>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                @foreach ([1,2,3,1,2,3,1,2] as $item)
                    <figure>
                        <img class="w-full rounded" src="{{ asset("assets/home/ofi{$item}.jpg") }}" alt="">
                    </figure>
                @endforeach
            </div>
        </x-website.container>
    </section>
    <section class="py-10">
        <x-website.container>
            <h3 class="title_large">Nuestro Trabajo</h3>
            <div class="grid grid-cols-2 gap-x-3 gap-y-10 md:grid-cols-3 lg:grid-cols-4">
                @foreach (range(1,9) as $number)
                    <figure>
                        <img class="object-cover w-full h-52 rounded shadow"
                             src="{{ asset("assets/home/ambiente-laboral-{$number}.jpg") }}" alt="">
                    </figure>
                @endforeach
            </div>
        </x-website.container>
    </section>
    <x-website.footer/>
</x-website-layout>
