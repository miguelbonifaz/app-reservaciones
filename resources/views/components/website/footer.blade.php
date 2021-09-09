@props([
    'mt' => 'mt-10'
])
<footer {{ $attributes->merge(['class' => "py-6 {$mt} text-center text-white uppercase bg-mariajose_gray"]) }}>
    <p>Copyright {{ today()->format('Y') }} - {{ config('app.name') }}</p>
</footer>
