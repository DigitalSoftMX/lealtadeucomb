<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model{
    
    public $timestamps = false;
    protected $table= 'vouchers';
    protected $fillable = ['id', 'name', 'points', 'value', 'id_status', 'id_station', 'id_count_voucher','total_voucher'];

}
