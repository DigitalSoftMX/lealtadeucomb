<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class Change_Memberships extends Model{
    
    public $timestamps = false;
    protected $table= 'change_memberships';
    protected $fillable = ['id', 'qr_membership', 'id_users', 'qr_membership_old', 'todate'];

}
