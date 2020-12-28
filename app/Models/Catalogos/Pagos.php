<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{

    public $timestamps = true;
    protected $table = 'pagos';
    protected $fillable = ['id', 'pago', 'num_timbres', 'archivo', 'autorizado', 'id_estacion','id_empresa'];
}
