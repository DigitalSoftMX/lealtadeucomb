<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;
use App\User;

class Entrega2Form extends Form
{

    public function buildForm()
    {
        $this
        
            ->add('id_state', 'select',[
                'label'=>'Estado',
                'choices' => ['4' => 'Entrega Final'],
                'empty_value'=>'==== Select ===']);
        }
}