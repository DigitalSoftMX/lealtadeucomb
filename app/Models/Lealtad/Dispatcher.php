<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Dispatcher extends Model{
    
    public $timestamps = false;
    protected $table= 'dispatcher';
    protected $fillable = ['id', 'qr_dispatcher', 'active', 'todate', 'id_users', 'id_station'];

}
