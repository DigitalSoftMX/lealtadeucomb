<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Faturation extends Model{
    
    public $timestamps = false;
    protected $table= 'faturation';
    protected $fillable = ['id', 'active', 'todate', 'id_users', 'id_station'];

}