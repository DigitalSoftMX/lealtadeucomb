<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class UsuarioForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('name', 'text',['label'=>'Nombre'])
            ->add('last_name', 'text',['label'=>'Apellidos'])
            ->add('email', 'text',['label'=>'Correo electrónico'])
            ->add('password', 'password',['label'=>'Password','rules' => 'required'])
            ->add('sex', 'text',['label'=>''])
            ->add('cp', 'text',['label'=>'Código Postal'])
            ->add('phone', 'text',['label'=>'Teléfono'])
            ->add('cel_phone', 'text',['label'=>'Celular'])
            ->add('address', 'text',['label'=>'Dirección'])
            ->add('active', 'text',['label'=>'Activo en la App']);       
    }
}