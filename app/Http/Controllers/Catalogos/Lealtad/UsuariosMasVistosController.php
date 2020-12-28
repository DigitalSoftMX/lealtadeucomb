<?php namespace App\Http\Controllers\Catalogos\Lealtad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class UsuariosMasVistosController extends Controller {

    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['number_usuario'=>'QR','name'=>'Nombre','first_surname'=>'Apellido Paterno','second_surname'=>'Apellido Materno','totals'=>'Puntos','visits'=>'Visitas', 'id'=>'Acciones'];
        $this->name = 'Usuarios con mas puntos';
        $this->name_plural = 'fa fa-child';
        $this->form = 'App\Core\Forms\Lealtad\UsuariosMasPuntosForm';
        $this->model = 'App\User';
        $this->url_prefix = 'usuarioconmaspuntos';
        $validation_add = [
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);

    }

}