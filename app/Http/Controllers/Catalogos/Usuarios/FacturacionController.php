<?php namespace App\Http\Controllers\Catalogos\Usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class FacturacionController extends Controller {

    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->field_list = ['nombre'=>'Nombre','rfc'=>'RFC','direccionFiscal'=>'Direccion Fiscal','emailFacturacion'=>'Correo de Facturacion','created_at'=>'Fecha de registro','id'=>'Acciones'];
        $this->field_list = ['rfc'=>'RFC','numfac'=>'N¨²mero de facturaci¨®n','created_at'=>'Fecha de registro','id'=>'Acciones'];
        $this->name = 'Facturacion';
        $this->name_plural = 'fa fa-address-card-o';
        $this->form = 'App\Core\Forms\Admin\FacturacionForm';
        $this->model = 'App\Models\Catalogos\Facturacion';
        $this->url_prefix = 'usuariofacturacion';
        $validation_add = [
           ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);

    }

}