@component('mail::message')
# Apreciado(a) {{ $customer }}

Esta es la confirmación de su cita con los siguientes datos:

@if (collect($dateAndHour)->count() == 1)
@foreach($dateAndHour as $data)
- Fecha: {{ $data['date'] }}
- Hora: {{ $data['start_time'] }}
@endforeach
@endif
- Lugar: {{ $location }}
- Profesional: {{ $employee }}
- Valor: {{ $value }}
- Servicio: {{ $service }}

@if (collect($dateAndHour)->count() > 1)
### Con las siguientes fechas:
@foreach($dateAndHour as $data)
- Fecha: {{ $data['date'] }} / Hora: {{ $data['start_time'] }}
@endforeach

@endif
Gracias por confiar en nosotros.<br><br>

{{ config('app.name') }}
@endcomponent