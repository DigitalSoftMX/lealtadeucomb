<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model{
    
    public $timestamps = true;
    protected $table= 'tickets';
    protected $fillable = ['id', 'number_usuario', 'generado', 'number_ticket', 'number_valor', 'punto', 'litro', 'producto', 'costo', 'id_gas','number_gas','descrip','fh_ticket','ip_user'];
}


