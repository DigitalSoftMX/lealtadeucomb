<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Cat_State_USer extends Model{
    
    public $timestamps = false;
    protected $table= 'cat_state_user';
    protected $fillable = ['id', 'name_state_user'];

}
