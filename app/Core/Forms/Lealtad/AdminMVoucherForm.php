<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;

class AdminMVoucherForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('qr_membership', 'text',['label'=>'QR del Usuario'])
            ->add('id_station', 'text',['label'=>'']);
      }
}