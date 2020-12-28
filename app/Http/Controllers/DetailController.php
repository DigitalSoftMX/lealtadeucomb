<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class DetailController extends Controller
{
   public function downloadFile($file){

      $path = storage_path('app/public/').$file.".3gp";
    
       return response()->download($path);
    }
    
    public function downloadFileSalida($file){

      $path = storage_path('app/public/registro/').$file.".jpg";
    
       return response()->download($path);
    }
    
    public function downloadFileAcceso($file){

      $path = storage_path('app/public/').$file.".jpg";
    
       return response()->download($path);
    }
}
