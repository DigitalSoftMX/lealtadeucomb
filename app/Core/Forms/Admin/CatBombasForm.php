<?php 

namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\Models\Catalogos\CatBombas;

class CatBombasForm extends Form
{

    public function buildForm()
    {
        $this

            ->add('nombre', 'text', ['label' => 'Nombre Bomba', 'rules' => 'required'])
            ->add('numero', 'text', ['label' => 'N&uacute;mero Bomba', 'rules' => 'required'])
            ->add('id_estacion', 'text', ['label' => ' ', 'rules' => 'required'])
            ;
    }
}
