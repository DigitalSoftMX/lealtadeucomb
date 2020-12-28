<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class PerfilForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('name', 'text',['label'=>'Nombre','rules' => 'required'])
            ->add('first_name', 'text',['label'=>'Apellido Paterno','rules' => 'required'])
            ->add('second_name', 'text',['label'=>'Apellido Materno','rules' => 'required'])
            ->add('username', 'text',['label'=>'Usuario','rules' => 'required'])
            ->add('email', 'text',['label'=>'Correo electr&oacute;nico','rules' => 'required'])
            ->add('sex', 'text',['label'=>' ','rules' => 'required'])
            ->add('phone', 'text',['label'=>'Tel&eacute;fono','rules' => 'numeric'])
            ;
    }
}