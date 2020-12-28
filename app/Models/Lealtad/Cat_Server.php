<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Cat_server extends Model{
    
    public $timestamps = false;
    protected $table= 'cat_server';
    protected $fillable = ['id', 'ip_server', 'db_name', 'db_user', 'db_pass', 'active'];

}
