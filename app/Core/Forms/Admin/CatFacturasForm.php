<?php

namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\Models\Catalogos\CatFacturas;

class CatFacturasForm extends Form
{

    public function buildForm()
    {
        $this

            ->add('nombre', 'text', ['label' => 'Nombre Factura', 'rules' => 'required'])
            ->add('rfc', 'text', ['label' => 'RFC Factura', 'rules' => 'required'])
            ->add('numero', 'text', ['label' => 'Numero Factura', 'rules' => 'required'])
            ->add('direccion', 'text', ['label' => 'Direccion Factura', 'rules' => 'required'])
            ->add('email', 'text', ['label' => 'Correo Factura', 'rules' => 'required'])
            ->add('id_user', 'text', ['label' => '', 'rules' => 'required']);
    }
}
