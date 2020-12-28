<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class DispatcherUserForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('name', 'text',['label'=>'Nombre','rules' => 'required|string|max:255'])
            ->add('app_name', 'text',['label'=>'Appellidos', 'rules' => 'required|max:255'])
            ->add('email', 'text',['label'=>'Correo electrónico'])
            ->add('password', 'password',['label'=>'Password', 'rules' => 'required|string|min:6'])
            ->add('sex', 'text',['label'=>'Sexo'])
            ->add('cp', 'text',['label'=>'Código Postal','rules' => 'required'])
            ->add('phone', 'text',['label'=>'Teléfono'])
            ->add('cel_phone', 'text',['label'=>'Celular'])
            ->add('address', 'text',['label'=>'Dirección']);       
    }
}

