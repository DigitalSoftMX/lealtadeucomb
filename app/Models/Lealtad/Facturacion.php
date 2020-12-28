<?php 

namespace App\Models\Catalogos;
use Illuminate\Database\Eloquent\Model;

class Facturacion extends Model{
    
    public $timestamps = true;
    protected $table= 'facturas';
    //protected $fillable = ['id', 'nombre', 'rfc', 'direccionFiscal', 'emailFacturacion', 'id_user'];
    protected $fillable = ['id', 'rfc', 'numfac','id_user'];

}