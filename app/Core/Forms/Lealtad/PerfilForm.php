<?php namespace App\Core\Forms\Lealtad;

use Kris\LaravelFormBuilder\Form;
use App\User;
use App\Models\Catalogos\Role_User;
use App\Models\Catalogos\Role;


class PerfilForm extends Form
{

    public function buildForm()
    {
        $id = \Auth::user()->id;
        $rol = Role_User::where('user_id', '=', $id)->value('role_id');
        if ($rol == 1 || $rol == 3 || $rol == 2 || $rol == 6) { //verifica si es un usuario
            $this
            ->add('name', 'text',['label'=>'Nombre'])
            ->add('first_surname', 'text',['label'=>'Apellido Paterno'])
            ->add('second_surname', 'text',['label'=>'Apellido Materno'])
            ->add('email', 'text',['label'=>'Correo electrónico'])
            ->add('password', 'password',['label'=>'Contrase&ntilde;a'])
            ->add('sex', 'text',['label'=>' '])
            ->add('phone', 'text',['label'=>'Teléfono'])
            ; 
            
            }
            else{
                 $this
                ->add('name', 'text',['label'=>'Nombre'])
                ->add('first_surname', 'text',['label'=>'Apellido Paterno'])
                ->add('second_surname', 'text',['label'=>'Apellido Materno'])
                ->add('email', 'text',['label'=>'Correo electrónico'])
                ->add('password', 'password',['label'=>'Contrase&ntilde;a'])
                ->add('sex', 'text',['label'=>' '])
                ->add('phone', 'text',['label'=>'Teléfono'])
                //->add('birthdate', 'date',['label'=>'Fecha de Nacimiento'])
                ; 
            }
            
    }
}