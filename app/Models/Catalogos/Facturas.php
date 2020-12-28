<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    public $timestamps = true;
    protected $table = 'facturas';
    protected $fillable = ['id', 'serie', 'fecha', 'sello', 'formapago', 'nocertificado', 'certificado', 'folio', 'uuid', 'fechatimbrado', 'sellocfd', 'subtotal', 'descuento', 'moneda', 'tipocambio', 'total', 'tipocombrobante', 'metodopago', 'lugarexpedicion', 'id_emisor', 'id_receptor', 'usocfdi', 'Claveproserv', 'nointerno', 'cantidad', 'claveunidad', 'descripcion', 'noidentificacion', 'valorunitario', 'importe', 'base', 'iva', 'descuentoD', 'id_estacion', 'id_bomba', 'archivoxml', 'archivopdf', 'estatus'];
}
