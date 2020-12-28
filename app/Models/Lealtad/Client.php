<?php 

namespace App\Models\Lealtad;
use Illuminate\Database\Eloquent\Model;

class Client extends Model{
    
    public $timestamps = false;
    protected $table= 'clients';
    protected $fillable = ['id', 'user_id', 'current_balance', 'shared_balance', 'points', 'image', 'birthdate', 'ids'];

}
