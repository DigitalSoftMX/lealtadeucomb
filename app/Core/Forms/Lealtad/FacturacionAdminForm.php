<?php namespace App\Core\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\User;

class FacturacionAdminForm extends Form
{

    public function buildForm()
    {
        $this
        
            //->add('nombre', 'text',['label'=>'Nombre', 'rules' => 'required'])
            ->add('rfc', 'text',['label'=>'RFC', 'rules' => 'required',])
            ->add('numfac', 'text',['label'=>'Numero de Facturación', 'rules' => 'required',])
            //->add('direccionFiscal', 'text',['label'=>'Direccion Fiscal','rules' => 'required'])
            //->add('emailFacturacion', 'text',['label'=>'Correo para Facturacion', 'rules' => 'required'])
            ->add('id_user', 'text',['label'=>'Membresia', 'rules' => 'required'])
            ;

      }
}