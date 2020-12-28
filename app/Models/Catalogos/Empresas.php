<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    public $timestamps = true;
    protected $table= 'empresas';
    protected $fillable=['id','nombre','direccion','telefono','imglogo','total_facturas','total_timbres','activo', 'id_user'];
}
