<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class ExchangeForm extends Form
{

    public function buildForm()
    {
        $this
        
            ->add('id_state', 'text',['label'=>'']);
        }
}