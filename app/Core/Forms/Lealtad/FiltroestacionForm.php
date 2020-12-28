<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class FiltroestacionForm extends Form
{

    public function buildForm()
    {
        date_default_timezone_set("America/Mexico_City");
        $mes = date('m') ; // Fecha por mes        
        $this
            ->add('min', 'date',['label'=>'Fecha de inicio',
                   'wrapper'=>['class'=>'form-group date']])
            ->add('max', 'date',['label'=>'Fecha final',
                   'wrapper'=>['class'=>'form-group date']]);
    }
}