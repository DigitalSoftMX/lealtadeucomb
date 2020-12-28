<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model{
    
    public $timestamps = false;
    protected $table= 'tickets';
    protected $fillable = ['id', 'number_usuario', 'generado', 'number_ticket', 'punto', 'litro', 'producto', 'costo', 'id_gas','number_gas','descrip','fh_ticket','ip_user'];
}


