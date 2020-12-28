<?php namespace App\Http\Controllers\Catalogos\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

   class UserEmpresasController extends Controller {


    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['empresa'=>'Empresa','name'=>'Nombres','app_name'=>'Apellido Paterno ','apm_name'=>'Apellido Materno ','email'=>'Email','telefono'=>'Teléfono','activo'=>'Activo','id'=>'Acciones'];
        $this->name = 'Usuarios Empresas';
        $this->name_plural = 'Usuarios Empresas';
        $this->form = 'App\Core\Forms\Admin\UserEmpresasForm';
        $this->model = 'App\User';
        $this->url_prefix = 'userempresas';
        $validation_add = [];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}