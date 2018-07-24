@component('mail::message')
# Nota de Venta Generada

Estimados, junto con saludarlos, informo que se ha generado la nota de venta **{{$notaVenta->numero}}**

@component('mail::button', ['url' => route('verNotaVenta',['numero' => $notaVenta->numero])])
Nota Venta
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent
