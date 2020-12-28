<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class UserEstaciones extends Model
{ 
    public $timestamps = true;
    protected $table = 'users_estaciones';
    protected $fillable = ['id', 'id_users','id_station'];
}
