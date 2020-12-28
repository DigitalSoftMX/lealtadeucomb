<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class CatPrecios extends Model
{
    public $timestamps = true;
    protected $table = 'cat_precios';
    protected $fillable = ['id', 'num_ticket', 'costo', 'costo_timbre', 'costo_admin', 'costo_timbre_admin', 'ganancia'];
}
