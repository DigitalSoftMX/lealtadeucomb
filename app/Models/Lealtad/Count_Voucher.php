<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class Count_Voucher extends Model{
    
    public $timestamps = false;
    protected $table= 'count_vouchers';
    protected $fillable = ['id', 'id_station', 'min', 'max'];

}
