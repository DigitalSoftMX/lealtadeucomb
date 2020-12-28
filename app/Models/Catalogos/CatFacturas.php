<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class CatFacturas extends Model
{
    public $timestamps = true;
    protected $table = 'cat_facturas';
    protected $fillable = ['id', 'nombre', 'rfc', 'numero', 'direccion', 'email', 'archivocer', 'archivokey', 'id_user'];
}
