<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class FacturaEmisor extends Model
{
    public $timestamps = true;
    protected $table = 'factura_emisor';
    protected $fillable = ['id', 'nombre', 'rfc', 'regimenfiscal', 'direccionfiscal', 'cp', 'emailfiscal', 'archivocer', 'archivokey', 'consituacion', 'nocertificado', 'passcerti', 'avredescripcion1', 'descripcion1', 'avredescripcion2', 'descripcion2', 'avredescripcion3', 'descripcion3', 'cuenta', 'pass', 'user', 'id_user','id_estacion','id_empresa'];
}