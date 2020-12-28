<?php namespace App\Http\Controllers\Catalogos\Lealtad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

   class PerfilController extends Controller {


    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['name'=>'Nombre','first_surname'=>'Apellido Paterno','second_surname'=>'Apellid Materno','email'=>'Correo electrónico','id'=>'Acciones'];
        $this->name = 'Perfil';
        $this->name_plural = 'fa fa-user';
        $this->form = 'App\Core\Forms\Lealtad\PerfilForm';
        $this->model = 'App\User';
        $this->url_prefix = 'perfil';
        $validation_add = [
            'name'=>'required|string|max:255',
            'cp'=>'required|numeric',
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}