<?php namespace App\Http\Controllers\Catalogos\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

   class UserClientController extends Controller {


    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->field_list = ['username'=>'Membresia', 'name'=>'Nombres','app_name'=>'Apellido Paterno ','apm_name'=>'Apellido Materno ','rfc'=>'RFC','totals'=>'Puntos','activo'=>'Activo','id'=>'Acciones'];
        $this->field_list = ['username'=>'Membresía', 'name'=>'Nombres','first_surname'=>'Apellido Paterno ','second_surname'=>'Apellido Materno ','email'=>'Correo Electrónico','totals'=>'Puntos','id'=>'Acciones'];
        $this->name = 'Usuarios';
        $this->name_plural = 'Usuarios';
        $this->form = 'App\Core\Forms\Admin\UserClientForm';
        $this->model = 'App\User';
        $this->url_prefix = 'userclient';
        $validation_add = [];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}