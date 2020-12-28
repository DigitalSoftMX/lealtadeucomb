<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class CatBombas extends Model
{ 
    public $timestamps = true;
    protected $table = 'cat_bombas';
    protected $fillable = ['id', 'nombre', 'numero', 'id_estacion', 'id_empresa', 'activo'];
}
