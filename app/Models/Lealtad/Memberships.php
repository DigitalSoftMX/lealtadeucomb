<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class Memberships extends Model{
    
    public $timestamps = false;
    protected $table= 'tarjeta';
    protected $fillable = ['id', 'number_usuario', 'active', 'todate', 'totals', 'visits', 'id_users','id_station'];

}
