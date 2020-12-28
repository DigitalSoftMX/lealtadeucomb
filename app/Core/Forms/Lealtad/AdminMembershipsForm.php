<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class AdminMembershipsForm extends Form
{

    public function buildForm()
    {
        $this
        
            ->add('name', 'text',['label'=>'Nombre', 'rules' => 'required'])
            ->add('last_name', 'text',['label'=>'Apellidos', 'rules' => 'required'])
            ->add('email', 'text',['label'=>'email'])
            ->add('sex', 'text',['label'=>'sexo', 'rules' => 'required'])
            ->add('cel_phone', 'text',['label'=>'celular'])
            ->add('birthdate', 'date',['label'=>'Fecha de Nacimiento', 'rules' => 'required'])
             ->add('qr_membership', 'text',['label'=>'QR', 'rules' => 'required'])
            ->add('active', 'text',['label'=>'Activo', 'rules' => 'required']);
            //->add('id_station', 'text',['label'=>'Estacion']);
      }
}