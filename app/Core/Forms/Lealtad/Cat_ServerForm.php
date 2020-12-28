<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

class Cat_ServerForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('ip_server', 'text',['label'=>'IP del Servidor', 'rules' => 'required'])
            ->add('db_name', 'text',['label'=>'Nombre', 'rules' => 'required'])
            ->add('db_user', 'text',['label'=>'Usuario', 'rules' => 'required'])
            ->add('db_pass', 'text',['label'=>'Password', 'rules' => 'required'])
            ->add('active', 'text',['label'=>'Activo', 'rules' => 'required']);
    }
}