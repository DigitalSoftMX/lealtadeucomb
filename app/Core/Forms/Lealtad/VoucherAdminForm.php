<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;

class VoucherAdminForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('name', 'text',['label'=>'Nombre','rules' => 'required'])
            ->add('points', 'text',['label'=>'Puntos','rules' => 'required|numeric'])
            ->add('value', 'text',['label'=>'Valor','rules' => 'required|numeric'])
            ->add('id_status', 'text',['label'=>' ','rules' => 'required'])
            ->add('id_station', 'text',['label'=>' ','rules' => 'required']);
        
    }
}