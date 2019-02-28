
@component('mail::message')
# Modificación de Proforma

Estimados, muy buen día. <br>
Junto con saludarlos informo que se ha generado una nueva versión de la siguiente orden de despacho internacional a <strong>{{$proforma->cliente->pais->nombre}}</strong>

@component('mail::button', ['url' => route('verProforma',['numero' => $proforma->numero])])
Proforma {{$proforma->numero}}
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent
