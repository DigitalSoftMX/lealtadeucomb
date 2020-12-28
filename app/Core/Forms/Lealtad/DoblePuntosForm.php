<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;
use App\User;

class DoblePuntosForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('active', 'text',['label'=>' ']);       
    }
}