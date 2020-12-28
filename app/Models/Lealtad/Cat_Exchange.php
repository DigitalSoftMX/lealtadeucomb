<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Cat_Exchange extends Model{
    
    public $timestamps = false;
    protected $table= 'cat_exchange';
    protected $fillable = ['id', 'name_exchange'];

}