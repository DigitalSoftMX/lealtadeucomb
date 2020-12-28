<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;

class VoucherForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('name', 'text',['label'=>'Nombre'])
            ->add('points', 'text',['label'=>'Puntos'])
            ->add('value', 'text',['label'=>'Valor'])
            ->add('id_status', 'text',['label'=>''])
            ->add('id_station', 'text',['label'=>'']);
    }
}