<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model{
    
    public $timestamps = true;
    protected $table= 'permissions';
    protected $fillable = ['id', 'name', 'display_name', 'description', 'created_at', 'updated_at', 'deleted_at'];

}
