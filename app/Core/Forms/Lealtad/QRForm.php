<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class QRForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('qr_membership', 'text',['label'=>'QR'])
            ->add('active', 'text',['label'=>'Activo'])
            ->add('qr', 'file',['label'=>'Subir']);
    }
}