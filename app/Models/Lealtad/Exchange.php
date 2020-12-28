<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model{
    
    public $timestamps = true;
    protected $table= 'canjes';
    protected $fillable = ['id', 'identificador', 'conta', 'id_estacion', 'punto', 'value', 'number_usuario', 'generado', 'estado', 'descrip', 'image', 'estado_uno', 'estado_dos', 'estado_tres'];

}
