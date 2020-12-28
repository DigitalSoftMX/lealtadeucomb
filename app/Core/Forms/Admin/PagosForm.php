<?php

namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\Models\Catalogos\Facturas;

class PagosForm extends Form
{

    public function buildForm()
    {
        $this

            ->add('pago', 'text', ['label' => 'Pago', 'rules' => 'required'])
            ->add('num_timbres', 'text', ['label' => 'Numero Timbres', 'rules' => 'required'])
            ->add('archivo', 'text', ['label' => 'Archivo', 'rules' => 'required'])
            ->add('autorizado', 'text', ['label' => 'Autorizado', 'rules' => 'required'])
            ->add('id_estacion', 'text', ['label' => 'ID Estacion', 'rules' => 'required']);
    }
}
