<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class ConjuntoMembership extends Model{
    
    public $timestamps = true;
    protected $table= 'conjunto_memberships';
    protected $fillable = ['id', 'membresia', 'number_usuario', 'puntos'];

}
