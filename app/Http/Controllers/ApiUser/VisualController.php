<?php
 
namespace App\Http\Controllers\ApiUser;
 
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\Role_User;
use App\Models\Catalogos\Faturation;
use App\Models\Catalogos\Visual;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Mail;
use DB;
use Illuminate\Support\Facades\Crypt;


class VisualController extends Controller
{

    
   public function visual(Request $request){
        
        //Crypt::setMode('ctr');
        //Crypt::setCipher($cipher);
        
       // $encrypted = Crypt::encryptString('?id=959894&fh=20191213094127&ca=0000000010.395000&im=0000000200.000000&ti=1&es=13110');
       //?id=00001&fp=03&st=1923.17&ds=0&to=2223.00&le=721006&de=Magna&vu=16.567145&ca=116.0834&es=123&bo=3
        //$decrypted = Crypt::decryptString($encrypted);

        //dd($encrypted);
        //dd($decrypted);
        
        //dd($request->all());
        $cadena = "?id=" . $request->id . "&fp=" . $request->fp . "&st=" . $request->st . "&tt=" . $request->tt . "&de=" . $request->de . "&vu=" . $request->vu . "&ca=" . $request->ca . "&es=" . $request->es . "&bo=" . $request->bo . "&fh=" . $request->fh ;
        
        $encrypted = Crypt::encryptString($request->id);
        $decrypted = Crypt::decryptString($encrypted);

         
        $validacion = $request->id;
       
        if($validacion == " "){
             $final = "no es un codigo valido";    
        }
        else{
         Visual::create([
                     'number_ticket' => $decrypted,
                     'number_visual' => $encrypted,
                     'cadena' => $cadena,
                     ]);
            $final = $encrypted;  
        }
        
          return response($final);
   }

}