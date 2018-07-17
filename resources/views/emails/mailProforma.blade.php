
@component('mail::message')
# Proforma Generada

Estimados, muy buenas tardes. <br>
Junto con saludarlos informo que se ha generado la siguiente orden de despacho internacional a <strong>{{$proforma->cliente->pais}}</strong>

@component('mail::panel')
<strong>
    este es un correo de prueba,
    favor confirmar la recepcion del mismo.
</strong>
@endcomponent
@endcomponent
