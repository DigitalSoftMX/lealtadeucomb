<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class UserEstacionesEditForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('name', 'text',['label'=>'Nombre','rules' => 'required'])
            ->add('first_surname', 'text',['label'=>'Apellido Paterno','rules' => 'required'])
            ->add('second_surname', 'text',['label'=>'Apellido Materno','rules' => 'required'])
            ->add('password', 'password',['label'=>'Contrase&ntilde;a','rules' => ''])
            ->add('email', 'text',['label'=>'Correo electr&oacute;nico','rules' => 'required'])
            //->add('sex', 'text',['label'=>' ','rules' => 'required'])
            //->add('phone', 'text',['label'=>'Tel&eacute;fono','rules' => 'numeric'])
            //->add('id_station', 'text',['label'=>' ','rules' => 'numeric'])
            //->add('activo', 'text',['label'=>' '])
            ;       
    }
}