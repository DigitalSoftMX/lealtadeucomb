<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class FiltroForm extends Form
{

    public function buildForm()
    {
        date_default_timezone_set("America/Mexico_City");
        $mes = date('m') ; // Fecha por mes        
        $this
            ->add('min', 'select',[
                'label'=>'Fecha por mes',
                'choices' => ['01' => 'Enero',
                              '02' => 'Febrero',
                              '03' => 'Marzo',
                              '04' => 'Abril',
                              '05' => 'Mayo',
                              '06' => 'Junio',
                              '07' => 'Julio',
                              '08' => 'Agosto',
                              '09' => 'Septiembre',
                              '10' => 'Octubre',
                              '11' => 'Noviembre',
                              '12' => 'Diciembre'],
                'empty_value' => [$mes => 'Selecciona el mes']]);
    }
}