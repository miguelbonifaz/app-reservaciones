<x-website-layout>
    <x-website.header.header/>
    <x-website.container>
        <x-website.main-title>
            Evaluaciones
        </x-website.main-title>
        <p class="mx-auto mb-12 max-w-xl text-center md:mb-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor
            incididunt ut labore et dolore
            magna aliqua.</p>
    </x-website.container>

    <section class="grid gap-4 px-4 sm:grid-cols-2 xl:grid-cols-4 lg:px-0 lg:gap-0">
        @foreach ([1,2,3,4] as $number)
            <figure>
                <img class="w-full" src="{{ asset("assets/home/foto{$number}.jpg") }}" alt="">
            </figure>
        @endforeach
    </section>

    <x-website.footer mt="mt-0"/>
</x-website-layout>
