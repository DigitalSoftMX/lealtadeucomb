<?php
 
namespace App\Http\Controllers\ApiUser;
 
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Catalogos\Memberships;
use App\Models\Catalogos\Station;
use App\Models\Catalogos\Tickets;
use App\Models\Catalogos\Voucher;
use App\Models\Catalogos\Awards;
use App\Models\Catalogos\Exchange;
use App\Models\Catalogos\History;
use App\Models\Catalogos\Dispatcher;
use App\Models\Catalogos\Role_User;
use App\Models\Catalogos\Faturation;
use App\Models\Catalogos\Cat_Server;
use App\Models\Catalogos\Change_Memberships;
use App\Models\Catalogos\DoublePoints;
use App\Models\Catalogos\Count_Voucher;
use App\Models\Catalogos\Cat_Qr;
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
        //$decrypted = Crypt::decryptString($encrypted);

        //dd($encrypted);
        //dd($decrypted);
        
        $cadena = $request->cadena;
        
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