<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class FaturationUserForm extends Form
{

    public function buildForm()
    {
        $this     
            ->add('name', 'text',['label'=>'Nombre', 'rules' => 'required|string|max:255'])
            ->add('last_name', 'text',['label'=>'Apellidos', 'rules' => 'required|max:255'])
            ->add('username', 'text',['label'=>'Usuario'])
            ->add('email', 'text',['label'=>'Email'])
            ->add('password', 'password',['label'=>'Password', 'rules' => 'required|string|min:6'])
            ->add('sex', 'text',['label'=>'Sexo', 'rules' => 'required'])
            ->add('cp', 'text',['label'=>'Código Postal'])
            ->add('cel_phone', 'text',['label'=>'Celular'])
            ->add('address', 'text',['label'=>'Dirección']);  
        
    }
}