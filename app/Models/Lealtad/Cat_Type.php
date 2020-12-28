<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Cat_Type extends Model{
    
    public $timestamps = false;
    protected $table= 'cat_type';
    protected $fillable = ['id', 'name_type'];

}