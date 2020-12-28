<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class Exchange_Award extends Model{
    
    public $timestamps = true;
    protected $table= 'canjes_awards';
    protected $fillable = ['id', 'identificador', 'conta', 'id_estacion', 'punto', 'value', 'number_usuario', 'generado', 'estado', 'descrip', 'estado_uno', 'estado_dos', 'estado_tres'];

}
