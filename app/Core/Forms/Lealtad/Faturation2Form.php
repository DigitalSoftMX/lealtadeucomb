<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class Faturation2Form extends Form
{

    public function buildForm()
    {
        $this
        
            ->add('id_users', 'text',['label'=>'Usuario'])
            ->add('id_station', 'text',['label'=>'Estación'])
            ->add('todate', 'date',['label'=>'Fecha'])
            ->add('active', 'text',['label'=>'Activar']);
      }
}
