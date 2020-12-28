<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;
use App\User;

class CountVaucherForm extends Form
{

    public function buildForm()
    {
        $this
            //->add('id_voucher', 'text',['label'=>'Nombre'])
            ->add('id_station', 'text',['label'=>' '])
            ->add('min', 'text',['label'=>'Número mínimo de vales', 'rules' => 'required|numeric'])
            ->add('max', 'text',['label'=>'Número máximo de vales', 'rules' => 'required|numeric']);
        }
}