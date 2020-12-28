<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
     public function index()
    {
        $users_list = \DB::table('users')->get();

    	return \View::make('usuarios/add_users')->with('users_list',$users_list);
    }

    public function store()
    {
 
         $name = Input::get('name');
         $last_name = Input::get('last_name').' '.Input::get('materno');
         $email = Input::get('email');
         $password = Input::get('password');

     
         $consulta = User::orderby('id', 'ASC')->where('email','=',$email)->get();


          if(count($consulta) > 0) 
            { 

	           \Session::flash('Mensaje','El usuario ya esta Registrado');

	        }
	        else
	        {

	        	 $user = User::create([
                'first_name' => $name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => bcrypt($password),
               ]);


            	  \Session::flash('Mensaje','Usuario Creado Correctamente');

	        }


 return redirect()->back();

    }
}
