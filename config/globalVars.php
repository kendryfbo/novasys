<?php

return [

    /*
    |
    | Declaracion de variable Globales accesibles en la aplicacion
    |
    */

/*----------------------------------------------------------------------------------*/

    /*
    | Variable que Representa el id del Tipo de Producto => PRODUCTO TERMINADO
    | Este id debe ser igual al de la table Tipo_familia. (creado a partir de semilla)
    */
    'PT' => 4,

    /*
    | Variable que Representa el id del Tipo de Producto => INSUMO
    | Este id debe ser igual al de la table Tipo_familia. (creado a partir de semilla)
    */
    'MP' => 1,

    /*
    | Variable que Representa el id del Tipo de Producto => PRE-PROCESO
    | Este id debe ser igual al de la table Tipo_familia. (creado a partir de semilla)
    */
    'PP' => 2,


    /*
    |     TIPOS DE INGRESOS A BODEGA
    */

    /*
    | Variable que Representa el id del ingreso Manual
    | Este id debe ser igual al de la table ingreso_tipo. (creado a partir de semilla)
    */
    'ingresoManual' => 1,

    /*
    | Variable que Representa el id del ingreso atravez de Termino de Proceso
    | Este id debe ser igual al de la table ingreso_tipo. (creado a partir de semilla)
    */
    'ingresoTP' => 2,

    /*
    | Variable que Representa el id del ingreso atravez de Orden de Compra
    | Este id debe ser igual al de la table ingreso_tipo. (creado a partir de semilla)
    */
    'ingresoOC' => 3,


    /*
    |     TIPOS DE DOCUMENTOS COMO PROFORMA Y NOTA DE VENTA
    */

    /*
    | Variable que Representa el id del Tipo de Documento
    | Este id debe ser igual al de la table tipo_documento.
    | "Tipo-Documento-Proforma"
    */
    'TDP' => 1,

    /*
    | Variable que Representa el id del Tipo de Documento
    | Este id debe ser igual al de la table tipo_documento.
    | "Tipo-Documento-NotaVenta"
    */
    'TDNV' => 2,



    /*
    |     AREAS
    */

    /*
    | Variable que Representa el id del Area BODEGA
    | Este id debe ser igual al de la table areas.
    */
    'areaBodega' => 5,



    /*
    |     STATUS ORDEN DE COMPRA
    */

    /*
    | Variable que Representa el id de Status Pendiente
    | Este id debe ser igual al de la table orden_compra_status.
    */
    'statusPendienteOC' => 1,
    /*
    | Variable que Representa el id de Status Ingresada
    | Este id debe ser igual al de la table orden_compra_status.
    */
    'statusIngresadaOC' => 2,
    /*
    | Variable que Representa el id de Status Ingresada
    | Este id debe ser igual al de la table orden_compra_status.
    */
    'statusCompletaOC' => 3,

    /*
    |     TIPO ORDEN DE COMPRA
    */

    /*
    | Variable que Representa el id de Orden de Compra Tipo BOLETA
    | Este id debe ser igual al de la table orden_compra_tipos.
    */
    'tipoOCBoleta' => 1,
    /*
    | Variable que Representa el id de Orden de Compra Tipo FACTURA EXCENTA de iva
    | Este id debe ser igual al de la table orden_compra_tipos.
    */
    'tipoOCHonorario' => 2,
    /*
    | Variable que Representa el id de Orden de Compra Tipo FACTURA
    | Este id debe ser igual al de la table orden_compra_tipos.
    */
    'tipoOCFactura' => 3,


];
