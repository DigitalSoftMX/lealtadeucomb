<?php

namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\Models\Catalogos\Facturas;

class FacturasForm extends Form
{

    public function buildForm()
    {
        $this

            ->add('nombre', 'text', ['label' => 'Nombre Factura', 'rules' => 'required'])
            ->add('folio', 'text', ['label' => 'Folio Factura', 'rules' => 'required'])
            ->add('archivo', 'text', ['label' => 'Archivo Factura', 'rules' => 'required'])
            ->add('hor_envio', 'text', ['label' => 'Hora Envio Factura', 'rules' => 'required'])
            ->add('hor_regreso', 'text', ['label' => 'Hora Regreso Factura', 'rules' => 'required']);
    }
}
