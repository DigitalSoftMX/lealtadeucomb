<?php namespace App\Http\Controllers\Catalogos\Lealtad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class UsuarioDetallesController extends Controller {

    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['number_usuario'=>'QR Membresía','generado'=>'QR Despachador','folios'=>'QR Ticket','punto'=>'Puntos','litro'=>'Litros', 'producto'=>'Producto','name'=>'Estación','descrip'=>'Concepto','id'=>'Acciones'];
        $this->name = 'Usuarios Movimientos Detallados';
        $this->name_plural = 'fa fa-child';
        $this->form = 'App\Core\Forms\Lealtad\UsuariosMasPuntosForm';
        $this->model = 'App\User';
        $this->url_prefix = 'usuariodetalle';
        $validation_add = [
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);

    }

}