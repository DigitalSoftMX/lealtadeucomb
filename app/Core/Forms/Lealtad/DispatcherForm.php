<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class DispatcherForm extends Form
{

    public function buildForm()
    {
        $this
        
            ->add('name', 'text',['label'=>'Nombre', 'rules' => 'required|string|max:255'])
            ->add('app_name', 'text',['label'=>'Apellidos', 'rules' => 'required|max:255'])
            ->add('email', 'text',['label'=>'Email'])
            ->add('password', 'password',['label'=>'Contraseña', 'rules' => 'required|string|min:6'])
            ->add('sex', 'text',['label'=>'Sexo', 'rules' => 'required'])
            ->add('cel_phone', 'text',['label'=>'Celular'])
            ->add('id_station', 'text',['label'=>'', 'rules' => 'required'])
            ->add('todate', 'date',['label'=>'Fecha de Nacimiento', 'rules' => 'required'])
             ->add('qr_dispatcher', 'text',['label'=>'QR', 'qr_dispatcher' => 'required|max:25'])
            ->add('active', 'text',['label'=>'Activo', 'rules' => 'required']);
            //->add('id_station', 'text',['label'=>'Estacion']);
      }
}
     