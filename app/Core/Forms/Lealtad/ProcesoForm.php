<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;
use App\User;

class ProcesoForm extends Form
{

    public function buildForm()
    {
        $this
        
            ->add('id_state', 'select',[
                'label'=>'Estado',
                'choices' => ['2' => 'Entrega'],
                'empty_value'=>'==== Select ===']);
        }
}