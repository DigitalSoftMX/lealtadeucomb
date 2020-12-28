<?php namespace App\Http\Controllers\Catalogos\Usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class MovementController extends Controller {

    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['number_usuario'=>'QR Membresía','punto'=>'Puntos','name'=>'Estación', 'descrip'=>'Concepto', 'fecha'=>'Fecha','folios'=>'Folio'];
        $this->name = 'Estado de Cuenta';
        $this->name_plural = 'fa fa-file-text-o';
        $this->form = 'App\Core\Forms\Admin\FiltroForm';
        $this->model = 'App\Models\Catalogos\Movement';
        $this->url_prefix = 'usuariomovement';
        $validation_add = [
            'qr_memberships'=>'required|max:25',
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);

    }

}