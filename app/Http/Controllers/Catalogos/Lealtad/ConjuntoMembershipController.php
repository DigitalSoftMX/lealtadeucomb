<?php namespace App\Http\Controllers\Catalogos\Lealtad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class ConjuntoMembershipController extends Controller {

    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['membresia'=>'Membresías Asignadas','number_usuario'=>'Membresía General', 'name'=>'Nombre', 'first_surname'=>'Apellido Paterno', 'puntos'=>'Puntos Asignados','id'=>'Acciones'];
        $this->name = 'Asignar Membresias';
        $this->name_plural = 'fa fa-folder-open';
        $this->form = 'App\Core\Forms\Lealtad\ConjuntoMembershipForm';
        $this->model = 'App\Models\Lealtad\ConjuntoMembership';
        $this->url_prefix = 'conjuntomembership';
        $validation_add = [
            'number_usuario'=>'required',
        ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);

    }

}