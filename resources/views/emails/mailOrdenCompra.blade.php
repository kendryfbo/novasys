@component('mail::panel')
    # Orden de Compra Generada

    Estimados {{$ordenCompra->proveedor->descripcion}}

        Se adjunta Orden de Compra N° {{$ordenCompra->numero}}.

    {{$ordenCompra->observaciones}}

    Nuestros horarios de recepción son de Lu-Vi de 8:00 a 13:00 y de 14:00 a 17:00.

    Toda(o) despacho debe venir con Orden de Compra.

    En caso de enviar Materia Prima o Material de Envase se debe entregar Ficha técnica y Certificado de Análisis.

    Las información de Calidad debe ser enviada por correo electrónico, antes de la recepción, a asistentecalidad@novafoods.cl Favor confirmar disponibilidad del despacho.

    Saludos,
@endcomponent
