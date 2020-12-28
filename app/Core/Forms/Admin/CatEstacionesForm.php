<?php 

namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\Models\Catalogos\CatEstaciones;

class CatEstacionesForm extends Form
{

    public function buildForm()
    {
        $this

            ->add('nombre', 'text', ['label' => 'Nombre de la estaci&oacute;n', 'rules' => 'required'])
            ->add('numero', 'text', ['label' => 'Numero de la estaci&oacute;n', 'rules' => 'required'])
            ->add('direccion', 'text', ['label' => 'Direcci&oacute;n de la estaci&oacute;n', 'rules' => 'required'])
            ->add('telefono', 'text', ['label' => 'Tel&eacute;fono de la estaci&oacute;n', 'rules' => 'required'])
            ->add('id_empresa', 'text', ['label' => ' ', 'rules' => 'required'])
           ;
    }
}
