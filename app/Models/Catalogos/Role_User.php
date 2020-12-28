<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Role_User extends Model{
    
    public $timestamps = false;
    protected $table= 'role_user';
    protected $fillable = ['user_id', 'role_id'];

}
