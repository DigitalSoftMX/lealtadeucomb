<?php

namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\Models\Catalogos\CatPrecios;

class CatPreciosForm extends Form
{

    public function buildForm()
    {
        $this

            ->add('num_ticket', 'text', ['label' => 'Numero de Timbres', 'rules' => 'required'])
            ->add('costo_timbre', 'text', ['label' => 'Precio por timbre al cliente', 'rules' => 'required'])
            ->add('costo_timbre_admin', 'text', ['label' => 'Precio por timbre administrador', 'rules' => 'required']);
    }
}
