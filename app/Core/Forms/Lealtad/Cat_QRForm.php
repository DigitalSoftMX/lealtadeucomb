<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class Cat_QRForm extends Form
{

    public function buildForm()
    {
        $this
        
            ->add('qr_ticket', 'text',['label'=>'Folio'])
            ->add('points', 'text',['label'=>'Puntos'])
            ->add('liters', 'text',['label'=>'Litros'])
            ->add('product', 'select',[
                'label'=>'Producto',
                'choices' => ['premiun' => 'Premium',
                              'magna' => 'Magna'],
                'empty_value'=>'==== Select ==='])    
            ->add('price', 'text',['label'=>'Precio']);
      }
}