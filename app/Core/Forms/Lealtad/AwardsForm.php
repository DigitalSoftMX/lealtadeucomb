<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

class AwardsForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('name', 'text',['label'=>'Nombre'])
            ->add('points', 'text',['label'=>'Puntos'])
            ->add('value', 'text',['label'=>'Valor'])
            ->add('days_deliver', 'text',['label'=>'Días para entregar'])
             ->add('validity', 'date',['label'=>'Vigencia',
                'wrapper'=>['class'=>'form-group date']])
           ->add('id_status', 'text',['label'=>'']);
           //->add('id_station', 'text',['label'=>'Estacion']);
    }
}