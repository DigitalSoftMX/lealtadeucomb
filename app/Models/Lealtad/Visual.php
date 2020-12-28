<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Visual extends Model{
    
    public $timestamps = true;
    protected $table= 'visual';
    protected $fillable = ['id', 'number_ticket', 'number_visual', 'cadena'];
}


