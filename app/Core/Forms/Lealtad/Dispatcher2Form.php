<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class Dispatcher2Form extends Form
{

    public function buildForm()
    {
        $this
        
            ->add('qr_dispatcher', 'text',['label'=>'QR'])
            ->add('active', 'text',['label'=>'Activo'])
            ->add('id_station', 'text',['label'=>'']);
   
    }
}