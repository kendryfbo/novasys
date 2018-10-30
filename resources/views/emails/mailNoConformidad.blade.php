@component('mail::panel')
    # No Conformidad Generada

    Estimados,

    No Conformidad N° {{$noConformidad->id}} se ha generado en Sistema.

        {{$noConformidad->observaciones}}

    Contáctese con el área correspondiente para solucionar este inconveniente lo antes posible.

    Muchas gracias

    Saludos,
@endcomponent
