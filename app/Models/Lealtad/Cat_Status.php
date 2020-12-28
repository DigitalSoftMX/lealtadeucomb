<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Cat_Status extends Model{
    
    public $timestamps = false;
    protected $table= 'cat_status';
    protected $fillable = ['id', 'name_status'];

}
