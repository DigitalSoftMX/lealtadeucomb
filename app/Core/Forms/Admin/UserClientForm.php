<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class UserClientForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('name', 'text',['label'=>'Nombre','rules' => 'required'])
            ->add('first_name', 'text',['label'=>'Apellido Paterno','rules' => 'required'])
            ->add('second_name', 'text',['label'=>'Apellido Materno','rules' => 'required'])
            ->add('username', 'text',['label'=>'N&uacute;mero Cliente','rules' => 'required'])
            ->add('password', 'password',['label'=>'Contrase&ntilde;a','rules' => ''])
            ->add('email', 'text',['label'=>'Correo electr&oacute;nico','rules' => 'required'])
            ->add('sex', 'text',['label'=>' ','rules' => 'required'])
            ->add('phone', 'text',['label'=>'Tel&eacute;fono','rules' => 'numeric'])
            ->add('active', 'text',['label'=>' '])
            ;       
    }
}