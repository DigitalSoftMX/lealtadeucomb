<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class FacturaReceptor extends Model
{
    public $timestamps = true;
    protected $table = 'factura_receptor';
    protected $fillable = ['id', 'nombre', 'rfc', 'usocfdi', 'emailfiscal', 'id_user'];
}