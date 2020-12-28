<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class StationForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('name', 'text',['label'=>'Nombre', 'rules' => 'required'])
            ->add('address', 'text',['label'=>'Dirección', 'rules' => 'required'])
            ->add('number_station', 'text',['label'=>'Numero de Estacion', 'rules' => 'required|numeric'])
            //->add('id_type', 'text',['label'=>'Tipo', 'rules' => 'required'])
            //->add('id_comes', 'text',['label'=>'Nombre del servidor', 'rules' => 'required'])
            ;
    }
}