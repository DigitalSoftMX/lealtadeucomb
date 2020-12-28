<?php

namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\Models\Catalogos\Empresas;

class EmpresaForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('nombre', 'text', ['label' => 'Nombre de la empresa', 'rules' => 'required'])
            ->add('direccion', 'text', ['label' => 'Direcci&oacute;n de la empresa', 'rules' => 'required'])
            ->add('telefono', 'text', ['label' => 'Tel&eacute;fono de la empresa', 'rules' => 'required'])
            ->add('imglogo', 'file', ['label' => 'Logo de la empresa subir click', 'rules' => ''])
            //->add('total_facturas', 'text', ['label' => 'Total de facturas de la empresa'])
            //->add('total_timbres', 'text', ['label' => 'Total de timbres de la empresa'])
            ->add('activo', 'text', ['label' => ' ', 'rules' => 'required'])
            ->add('id_user', 'text', ['label' => ' ', 'rules' => 'required']);
    }
}
