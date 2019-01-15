@component('mail::message')
# Orden Egreso Generada

Estimados, junto con saludarlos, informo que se ha generado la orden de egreso **{{$egreso->numero}}**

Se adjunta Registro de Inspección de Productos Terminados para Despacho.
@component('mail::button', ['url' => route('verEgreso',['numero' => $egreso->numero])])
Orden Egreso {{$egreso->numero}}
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent
