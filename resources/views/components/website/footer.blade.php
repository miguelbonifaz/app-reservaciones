@props([
    'mt' => 'mt-10'
])

<footer {{ $attributes->merge(['class' => "py-6 {$mt} text-center text-white uppercase bg-mariajose_gray"]) }}>
    <div class="container text-sm mx-auto flex justify-between items-center">
        <div>
            <a href="">terminos y condiciones</a> -
            <a href="">politicas de devolución</a>
        </div>
        <p>Copyright {{ today()->format('Y') }} - {{ config('app.name') }}</p>
    </div>
</footer>
