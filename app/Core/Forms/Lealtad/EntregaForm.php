<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;
use App\User;

class EntregaForm extends Form
{

    public function buildForm()
    {
        $this
        
            ->add('id_state', 'select',[
                'label'=>'Estado',
                'choices' => ['3' => 'Cobrar'],
                'empty_value'=>'==== Select ===']);
        }
}