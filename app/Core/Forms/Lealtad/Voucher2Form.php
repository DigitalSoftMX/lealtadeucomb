<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

class Voucher2Form extends Form
{

    public function buildForm()
    {
        $this
            ->add('id_station', 'text',['label'=>'']);
      }
}