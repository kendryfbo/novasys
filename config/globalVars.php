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
    | Variable que Representa el id del Tipo de ingreso
    | Este id debe ser igual al de la table ingreso_tipo. (creado a partir de semilla)
    */

    'ingresoManual' => 1,

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

];
