<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;
use App\User;

class MembershipsForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('qr_membership', 'text',['label'=>'QR'])
            ->add('active', 'text',['label'=>'Activo']);
    }
}