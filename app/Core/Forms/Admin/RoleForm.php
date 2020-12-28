<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class RoleForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('name', 'text',['label'=>'Nombre'])
            ->add('display_name', 'text',['label'=>'Clave'])
            ->add('description', 'text',['label'=>'Descripcion']);
    }
}