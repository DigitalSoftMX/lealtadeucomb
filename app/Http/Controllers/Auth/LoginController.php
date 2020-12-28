<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use App\Models\Catalogos\Role_User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    
    protected function credentials(Request $request)
    {
      $login = $request->input($this->username());
    
    // Comprobar si el input coincide con el formato de E-mail
    
     $valema = (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $login, $matches));
       
        
        if($valema == true){
             $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        }
        else{
             $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'username' : 'username';
        }

        $prueba = $login;    
        $result = User::where('username', '=', $prueba)->value('id');
        $result2 = Role_User::where('user_id', '=', $result)->value('role_id');
         if($result2 == 5){
                   return [
                   $field => $login,
                   'password' => $request->input('password')
                   ];
                  
      }
         else{
                return [
                   $field => $login,
                    'password' => $request->input('password')
                   ];       
         }
       
    }
    
    public function username()
    {
     return 'login';
    }
}
