<?php

namespace App\Http\Controllers\Catalogos\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\Role_User;
use App\Models\Catalogos\Role;
use App\Core\Util\CatalogTrait;

class CatBombasController extends Controller
{
    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->middleware('auth');
        $this->field_list = ['nombre' => 'Nombre', 'numero' => 'Numero', 'estacion' => 'Estacion', 'empresa' => 'Empresa', 'id' => 'Acciones'];
        $this->name = 'Bombas';
        $this->name_plural = 'Bombas';
        $this->form = 'App\Core\Forms\Admin\CatBombasForm';
        $this->model = 'App\Models\Catalogos\CatBombas';
        $this->url_prefix = 'catbombas';
        $validation_add = [];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);
    }
}
