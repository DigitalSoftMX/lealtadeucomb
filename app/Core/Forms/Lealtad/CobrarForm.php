<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;
use App\User;

class CobrarForm extends Form
{

    public function buildForm()
    {
        $this
        
            ->add('id_state', 'select',[
                'label'=>'Estado',
                'choices' => ['4' => 'Entrega Administración'],
                'empty_value'=>'==== Select ===']);
        }
}