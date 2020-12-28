<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class UserEstacion extends Model{
    
    public $timestamps = true;
    protected $table= 'users_estaciones';
    protected $fillable = ['id', 'id_users', 'id_station'];
}


