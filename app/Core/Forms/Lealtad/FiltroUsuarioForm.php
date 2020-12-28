<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class FiltroUsuarioForm extends Form
{

    public function buildForm()
    {
        date_default_timezone_set("America/Mexico_City");
        $mes = date('m') ; // Fecha por mes        
        $this
            ->add('membresia', 'text',['label'=>'Membresia'])
            ->add('nombre', 'text',['label'=>'Nombre'])
            ->add('lastname', 'text',['label'=>'Apellidos'])
            ->add('email', 'text',['label'=>'Correo electronico'])
            ;
    }
}