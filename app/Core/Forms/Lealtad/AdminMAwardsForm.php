<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

class AdminMAwardsForm extends Form
{

    public function buildForm()
    {
        $this
                  ->add('qr_membership', 'text',['label'=>'QR del Usuario'])
                 ->add('id_station', 'text',['label'=>'']);
      }
}