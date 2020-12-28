<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;
use App\User;

class AdminMovementForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('qr_membership', 'text',['label'=>'QR Usuario','rules' => 'required'])
            ->add('qr_dispatcher', 'text',['label'=>'QR Despachador','rules' => 'required'])
            ->add('id', 'text',['label'=>'Folio','rules' => 'required|numeric'])
            ->add('ho', 'time',['label'=>'Hora','rules' => 'required'])
            ->add('fh', 'date',['label'=>'Fecha','rules' => 'required'])
            ->add('li', 'text',['label'=>'Litros','rules' => 'required|numeric'])
            ->add('pr', 'text',['label'=>'Precio','rules' => 'required|numeric'])
            ->add('ti', 'select',[
                'label'=>'Producto',
                'rules' => 'required|numeric',
                'choices' => ['1' => 'Magna',
                              '2' => 'Premium',
                              '3' => 'Diesel'],
                'empty_value'=>'==== Select ==='])
            ->add('ca', 'text',['label'=>'Puntos','rules' => 'required|numeric'])
            ->add('es', 'select',[
                'label'=>'Producto',
                'rules' => 'required|numeric',
                'choices' => ['1' => 'SOLE',
                              '2' => 'Cuautlapan ETE',
                              '3' => 'Zavaleta',
                              '4' => 'GAS ELE'],
                'empty_value'=>'==== Select ==='])
            ;
            
    }
}