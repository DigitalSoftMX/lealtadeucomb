<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;
use App\User;

class ConjuntoMembershipForm extends Form
{

    public function buildForm()
    {
        $this
            ->add('membresia1', 'text',['label'=>'Membres&iacute;a Asignada Uno'])
            ->add('membresia2', 'text',['label'=>'Membres&iacute;a Asignada Dos'])
            ->add('membresia3', 'text',['label'=>'Membres&iacute;a Asignada Tres'])
            ->add('membresia4', 'text',['label'=>'Membres&iacute;a Asignada Cuatro'])
            ->add('membresia5', 'text',['label'=>'Membres&iacute;a Asignada Cinco'])
            ->add('number_usuario', 'text',['label'=>'Membres&iacute;a General'])
            ;       
    }
}