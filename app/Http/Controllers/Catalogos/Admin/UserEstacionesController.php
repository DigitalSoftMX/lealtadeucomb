<?php namespace App\Http\Controllers\Catalogos\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

   class UserEstacionesController extends Controller {


    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['name'=>'Nombres','first_surname'=>'Apellido Paterno ','second_surname'=>'Apellido Materno ','id'=>'Acciones'];
        $this->name = 'Usuarios de Estaciones';
        $this->name_plural = 'Usuarios de Estaciones';
        $this->form = 'App\Core\Forms\Admin\UserEstacionesForm';
        $this->model = 'App\User';
        $this->url_prefix = 'userstation';
        $validation_add = [];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}