<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Role extends Model{
    
    public $timestamps = true;
    protected $table= 'roles';
    protected $fillable = ['id', 'name', 'display_name', 'description', 'created_at', 'updated_at', 'deleted_at'];

}
