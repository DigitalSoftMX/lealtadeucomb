<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Cat_Qr extends Model{
    
    public $timestamps = false;
    protected $table= 'cat_qr';
    protected $fillable = ['id', 'qr_ticket', 'points', 'liters', 'product', 'payment_made', 'price'];

}