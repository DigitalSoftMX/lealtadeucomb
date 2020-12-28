<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class History extends Model{
    
    public $timestamps = false;
    protected $table= 'history';
    protected $fillable = ['id', 'folio', 'folio_exchange', 'numero', 'todate_cerficado', 'id_admin', 'qr_memberships', 'id_product', 'id_award', 'id_station', 'id_exchange', 'points', 'value', 'todate'];
}
