<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class EnvioMail extends Model
{
    // Constantes
	const MAIL_PROFORMA_ID = 1; // id de Mail enviado atravez de proforma tabla envio_mail.
	const MAIL_NOTAVENTA_ID = 2; // id de Mail enviado atravez de Nota Venta tabla envio_mail.
	const MAIL_PROFORMA_DESPACHO_ID = 3; // id de Mail enviado Despacho Proforma tabla envio_mail.
	const MAIL_NOTAVENTA_DESPACHO_ID = 4; // id de Mail enviado Despacho Nota Venta tabla envio_mail.
	const MAIL_EGRESO_BODEGA_ID = 5; // id de Mail enviado Egreso de Bodega tabla envio_mail.
	const MAIL_EGRESO_CALIDAD_ID = 6; // id de Mail enviado Egreso de bodega a calidad tabla envio_mail.

    protected $table = 'envio_mail';

    protected $fillable = ['descripcion', 'activo'];

    /*
    |
    |   static Functions
    |
    */
    static function getMailListProforma() {

		$id = self::MAIL_PROFORMA_ID;
		$mailList = self::getMailList($id);

        return $mailList;
    }

    static function getMailListNotaVenta() {

		$id = self::MAIL_NOTAVENTA_ID;
		$mailList = self::getMailList($id);

		return $mailList;
    }

	static function getMailListProformaDespacho() {

		$id = self::MAIL_PROFORMA_DESPACHO_ID;
		$mailList = self::getMailList($id);

		return $mailList;
	}

    static function getMailListNotaVentaDespacho() {

		$id = self::MAIL_NOTAVENTA_DESPACHO_ID;
		$mailList = self::getMailList($id);

		return $mailList;
    }
    static function getMailListEgresoBodega() {

		$id = self::MAIL_EGRESO_BODEGA_ID;
		$mailList = self::getMailList($id);

		return $mailList;
    }
    static function getMailListEgresoCalidad() {

		$id = self::MAIL_EGRESO_CALIDAD_ID;
		$mailList = self::getMailList($id);

		return $mailList;
    }

	/*
	|
	| Private Functions
	|
	*/
	static private function getMailList($id) {

		return self::with(['detalles' => function($query) {
							$query->where('activo',1);
							}])
					->where('activo',1)
					->where('id',$id)
					->first();
	}

    /*
    |
    |   Relationships
    |
    */
    public function detalles() {

        return $this->hasMany('App\Models\Config\EnvioMailDetalle','envmail_id');
    }
}
