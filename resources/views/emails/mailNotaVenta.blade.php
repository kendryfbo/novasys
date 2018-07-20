@component('mail::message')
# Nota de Vente Generada

Estimados, junto con saludarlos, informo que se ha generado la nota de venta **{{$notaVenta->numero}}**

@component('mail::button', ['url' => ''])
Nota Venta
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent
