<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class DoblePuntos extends Model{
    
    public $timestamps = true;
    protected $table= 'doublepoint';
    protected $fillable = ['id', 'active'];

}