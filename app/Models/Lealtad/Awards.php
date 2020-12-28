<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class Awards extends Model{
    
    public $timestamps = false;
    protected $table= 'awards';
    protected $fillable = ['id', 'name', 'points', 'value', 'id_status','id_station', 'active', 'img'];

}
