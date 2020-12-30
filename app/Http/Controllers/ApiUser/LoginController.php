<?php
 
namespace App\Http\Controllers\ApiUser;
 
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Catalogos\Role_User;
use App\Models\Lealtad\Memberships;
use App\Models\Lealtad\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

class LoginController extends Controller
{

    public function login(Request $request){
        
        $username = $request->username;
        $password = $request->password;
        
         $password = Hash::make($request->password);
        
        $matches = null;
        $valema = (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $username, $matches));
        //dd($valema);
        
        if($valema == true){
            
          //$id_email = User::where('email', '=', $username)->where('active', '=', 0)->value('username');
          $id_email = User::where('email', '=', $username)->value('username');
          //  dd($id_email);
            $data = [
                        'username' => $id_email,
                        'password' => $request->password
                    ];
 
                if (\Auth::attempt($data)) 
                {
                    //$id_user = User::where('email', '=', $username)->where('active', '=', 0)->value('id');
                    $id_user = User::where('email', '=', $username)->value('id');
                    if($id_user != null){
                    $t = User::find($id_user);
                    $t->active = 0;
                    $t->save();
                    $respuesta = json_encode(array('resultado' => $id_email));
                    
                      $id_imagen = User::where('username', '=', $id_email)->value('image');
              
                    if($id_imagen == null){
                    $Base64Img = 'data:image/png;base64, '. DNS2D::getBarcodePNG($id_email, 'QRCODE'). ' ';
                    list(, $Base64Img) = explode(';', $Base64Img);
                    list(, $Base64Img) = explode(',', $Base64Img);
                    $Base64Img = base64_decode($Base64Img);
                    file_put_contents("img/usuarioimg/$id_email.jpg", $Base64Img); 
                    
                    $t = User::find($id_user);
                    $t->image = $id_email;
                    $t->save();
                    }
                    else{
                            if($id_imagen != $id_email){
                                 $t = User::find($id_user);
                                 $t->image = $id_email;
                                 $t->save();
                                 $id_client = Client::where('user_id', '=', $id_user)->value('id');
                                 $r = Client::find($id_client);
                                 $r->image = $id_email;
                                 $r->save();
                            }
                            
                          
                    }
                    
                   }
                   else{
                     $respuesta= json_encode(array('resultado' => 'La cuenta ya inicio sesion'));
                   }	     
                }    
                else{
                     $respuesta= json_encode(array('resultado' => 'El usuario o el password son incorrectos'));
                     }
            
        }
        else{
            
        $data = [
            'username' => $request->username,
            'password' => $request->password
        ];
          
                // Verificamos los datos
                if (\Auth::attempt($data)) 
                {
                
                    // Si nuestros datos son correctos mostramos la página de inicio
                  //   $id_user = User::where('username', '=', $username)->where('active', '=', 0)->value('id');
                     $id_user = User::where('username', '=', $username)->value('id');
                   // dd($id_user);
                   if($id_user != null){
                    $t = User::find($id_user);
                    $t->active = 0;
                    $t->save();
                    $respuesta = json_encode(array('resultado' => $username));
                    
                      $id_imagen = User::where('username', '=', $username)->value('image');
              
                    if($id_imagen == null){
                    $Base64Img = 'data:image/png;base64, '. DNS2D::getBarcodePNG($username, 'QRCODE'). ' ';
                    list(, $Base64Img) = explode(';', $Base64Img);
                    list(, $Base64Img) = explode(',', $Base64Img);
                    $Base64Img = base64_decode($Base64Img);
                    file_put_contents("img/usuarioimg/$username.jpg", $Base64Img); 
                    
                    $t = User::find($id_user);
                    $t->image = $username;
                    $t->save();
                    }
                    else{
                            if($id_imagen != $username){
                            $t = User::find($id_user);
                            $t->image = $username;
                            $t->save();
                            $id_client = Client::where('user_id', '=', $id_user)->value('id');
                                 $r = Client::find($id_client);
                                 $r->image = $id_email;
                                 $r->save();
                            }
                            
                          
                    }
                    
                   }
                   else{
                     $respuesta= json_encode(array('resultado' => 'La cuenta ya inicio sesion'));
                   }
                }
                else{
                     $respuesta= json_encode(array('resultado' => 'El usuario o el password son incorrectos'));
                     }
                
                }

        return response($respuesta);
    }
    
    
    public function registrar(Request $request){
    
    date_default_timezone_set("America/Mexico_City");
    $fecha = date('Y-m-d') ; // Fecha
            
     $name = $request->name;
     $first_name = $request->first_name;
     $second_name = $request->second_name;
     $email = $request->email;
     $sex = $request->sex;
     $phone = $request->telefono;
     
       
     $password = Hash::make($request->password);
    
        //verifica que tenga un correo y no se duplique
        $matches = null;
        $valema = (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $email, $matches));
        
        //dd($valema);
    if($email != ""){    
        if($valema == true){
       
             $exis = User::where('email', '=', $email)->value('id');
        //dd($exis);
        if($exis == null){
       
              $restuser = Memberships::orderBy('id', 'desc')->limit(1)->value('id_users');
       
              $mem = User::join('role_user', 'users.id', '=', 'role_user.user_id')
                               ->where('role_user.role_id', '=', 5)
                               ->where('users.id', '=', $restuser)
                               ->value('username');
                    
                     if($mem == null){
                         $nuevo = 2000001;
                     }
                     else{
                     $nuevo = $mem + 1;
                     }
                     
                $password = Hash::make($request->password);
                
                
               User::create([
                 'name' => $request->name,
                 'username' => $nuevo,
                 'first_surname' => $request->first_name,
                 'second_surname' => $request->second_name,
                 'password' => $password,
                 'email' => $request->email,
                 'sex' => $request->sex,
                 'phone' => $request->telefono,
                 'active' => 0,
                  ]);

               $id_use = User::where('email', '=', $request->email)->value('id');

               $dat = Role_User::create([
                'user_id' => $id_use,
                'role_id' => 5,
                ]);
                
                Memberships::create([
                     'number_usuario' => $nuevo,
                     'active' => 1,
                     'todate' => $fecha,
                     'totals' => 100,
                     'visits' => 0,
                     'id_users' => $id_use,
                  ]);
                  
                  Client::create([
                     'user_id' => $id_use,
                     'current_balance' => 0,
                     'shared_balance' => 0,
                     'points' => 0,
                     'image' => $nuevo,
                     'birthdate' => '0000-00-00',
                  ]);
                  
                    
                    $id_imagen = User::where('username', '=', $nuevo)->value('image');
                    
                    if($id_imagen == null){
                    $Base64Img = 'data:image/png;base64, '. DNS2D::getBarcodePNG($nuevo, 'QRCODE'). ' ';
                    list(, $Base64Img) = explode(';', $Base64Img);
                    list(, $Base64Img) = explode(',', $Base64Img);
                    $Base64Img = base64_decode($Base64Img);
                    file_put_contents("img/usuarioimg/$nuevo.jpg", $Base64Img); 
                    
                    $t = User::find($id_use);
                    $t->image = $id_imagen;
                    $t->save();
                    }
                
                $items = (string)$nuevo;
                $respuesta = json_encode(array('resultado' => $items));           
          }
          else{
           $respuesta = json_encode(array('resultado' => "Otro usuario ya tiene este mismo correo electronico"));           
          }
       }
       else{
           $respuesta = json_encode(array('resultado' => "No es un correo electronico"));           
       }
    }
    else{
           $respuesta = json_encode(array('resultado' => "No es un correo electronico"));           
       }
    
       
        return response($respuesta);
    }
    
    public function cerrar(Request $request){
        
        $username = $request->username;
         
         if($username != ""){
             
           $id_user = User::where('username', '=', $username)->value('id');
          
           $t = User::find($id_user);
           $t->active = 0;
           $t->save();
         
          $respuesta = json_encode(array('resultado' => $username));           
         }
         else{
              $respuesta = json_encode(array('resultado' => "No mando ningun usuario"));           
         }
        return response($respuesta);
         
    }
    
    
}
