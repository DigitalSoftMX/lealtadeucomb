<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Cat_State extends Model{
    
    public $timestamps = false;
    protected $table= 'cat_state';
    protected $fillable = ['id', 'name_state'];

}
