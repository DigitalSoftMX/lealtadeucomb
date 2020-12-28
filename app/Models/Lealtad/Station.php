<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class Station extends Model{
    
    public $timestamps = true;
    protected $table= 'station';
    protected $fillable = ['id', 'name', 'address', 'phone', 'email', 'total_facturas', 'total_timbres', 'id_empresa','id_type', 'number_station', 'ip', 'active'];

}
