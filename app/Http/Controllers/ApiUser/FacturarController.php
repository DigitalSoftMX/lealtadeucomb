<?php

namespace App\Http\Controllers\ApiUser;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\Role_User;
use App\Models\Catalogos\CatFacturas;
use App\Models\Lealtad\Station;
use App\Models\Catalogos\Empresas;
use App\Models\Catalogos\Facturas;
use App\Models\Catalogos\FacturaReceptor;
use App\Models\Catalogos\FacturaEmisor;
use App\Models\Catalogos\Visual;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Mail;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

use App\Http\Controllers\SWServices\Authentication\AuthenticationService as Authentication;
use App\Http\Controllers\SWServices\Stamp\StampService as StampService;
use App\Http\Controllers\SWServices\JSonIssuer\JsonIssuerService as jsonEmisionTimbrado;
use App\Http\Controllers\SWServices\JSonIssuer\JsonIssuerRequest as jsonIssuerRequest;



class FacturarController extends Controller
{
  public function facturar()
  {
                
                
    $verifica = Facturas::where('estatus', '=', 1)->count();

    if ($verifica >= 1) {
    $verificas = Facturas::where('estatus', '=', 1)->get();
      foreach($verificas as $veri){
          $iden = $veri->id;
          $folionew = $veri->folio;
          $fhnew = $veri->fecha;
          $fpnew = $veri->formapago; 
          $stnew = $veri->subtotal; 
          $ttnew = $veri->total;
          $receptor = $veri->id_receptor; 
          $canew = $veri->cantidad;
          $denew = $veri->descripcion; 
          $vunew = $veri->valorunitario; 
          $banew = $veri->base;
          $esnew = $veri->id_estacion; 
          $bonew = $veri->id_bomba;
   
        $empresa = Station::where('id', '=', $esnew)->value('id_empresa');
        $emisor = Empresas::where('id', '=', $empresa)->value('id_user');
         
            $result = self::sendcfdi($iden, $emisor, $receptor, $folionew, $fpnew, $stnew, $ttnew, $denew, $vunew, $canew, $esnew, $bonew, $fhnew, $banew);
      
            if ($result == true) {
                \DB::table('empresas')->where('id', "=", $empresa)->increment('total_facturas', 1);
                \DB::table('station')->where('id', "=", $esnew)->increment('total_facturas', 1);
                $respuesta = json_encode(array('resultado' => "La informacion se actualizo correctamente"));
            } else {
                $result = "El sistema no creo el cfdi o xml";
                //self::cambioservicio($facturas[0]->id, $result);
                $respuesta = json_encode(array('resultado' => "Error no se creo el cfdi"));
              // $result = self::sendcfdi($emisor, $receptor, $folionew, $fpnew, $stnew, $ttnew, $denew, $vunew, $canew, $esnew, $bonew, $fhnew, $banew);
            }
         }
     } else {
           $respuesta = json_encode(array('resultado' => 'No hay facturas que enviar'));
    }
    //*************************************************************************************************************************                            

    return response($respuesta);
    //return response()->json($beneficios);
  }

  public function sendcfdi($iden, $emisors, $receptors, $folionew, $fpnew, $stnew, $ttnew, $denew, $vunew, $canew, $esnew, $bonew, $fhnew, $banew)
  {
    //Creando carpeta con el numero de folio
    Storage::makeDirectory('factura/' . $folionew);
    //CONSULTAR DATOS DE RECEPTOR
    $datosReceptor = FacturaReceptor::where('id_user', '=', $receptors)->get();
    foreach ($datosReceptor as $dr) {
      $nombrerecept = $dr->nombre;
      $rfcrecept = $dr->rfc;
      $usocfdirecept = $dr->usocfdi;
      $emailfiscalrecept = $dr->emailfiscal;
    }
     //CONSULTAR DATOS DEL EMISOR
    //$datosEmisor = FacturaEmisor::where('id_user', '=', $emisors)->get();
    $datosEmisor = FacturaEmisor::where('id_estacion', '=', $esnew)->get();
    foreach ($datosEmisor as $em) {
      $nombreemi = $em->nombre;
      $rfcemi = $em->rfc;
      $regimenfiscalemi = $em->regimenfiscal;
      $direccionfiscalemi = $em->direccionfiscal;
      $cpemi = $em->cp;
      $emailfiscalemi = $em->emailfiscal;
      $avredescripcion1emi = $em->avredescripcion1;
      $descripcion1emi = $em->descripcion1;
      $avredescripcion2emi = $em->avredescripcion2;
      $descripcion2emi = $em->descripcion2;
      $avredescripcion3emi = $em->avredescripcion3;
      $descripcion3emi = $em->descripcion3;
      $nocertif = $em->nocertificado;
      $cuenta = $em->cuenta;
      $pass = $em->pass;
      $user = $em->user;
    }
     
        
     $importes = (($canew) * ($vunew));
     $importe = $stnew;
     $ivas = (($ttnew) - ($stnew));
     $iva = number_format((float)$ivas, 2, '.', '');
     
     if($denew == "Diesel"){ $claprod = "15101505"; $noidentificacion = $avredescripcion1emi; } 
                else if($denew == "Regular"){ $claprod = "15101514"; $noidentificacion = $avredescripcion2emi;} 
                       else{ $claprod = "15101515"; $noidentificacion = $avredescripcion2emi; }
         
   
     header('Content-Type: text/plain');
     date_default_timezone_set('America/Mexico_City');
     
     //fecha
        $ano = substr($fhnew, 0, 10);
        $hor = substr($fhnew, 11, 8);
     
     $fechas =  ($ano."T".$hor);                           
     //$fechas = date('Y-m-d\Th:i:s');

     $params = array(
    "url"=>"http://services.sw.com.mx",
    "user"=>$user,
    "password"=> $pass,
);

            $conceptos = null;
            $ImpuestosTotales = null;
            $complemento = null;
            $totalImpuestosTrasladados = 0;
            $Subtotal = 0;
            
            $comprobante["Complemento"] = null;
            $comprobante["Addenda"] = null;
            $comprobante["Version"] = "3.3";
            $comprobante["Serie"] = "CFDI-G".$iden;
            $comprobante["Folio"] = $folionew;
            $comprobante["Fecha"] = $fechas;
            $comprobante["Sello"] = "";
            $comprobante["FormaPago"] = $fpnew;
            $comprobante["NoCertificado"] = $nocertif;
            $comprobante["Certificado"] = "";
            $comprobante["CondicionesDePago"] = null;
            $comprobante["SubTotal"] = $stnew;
            $comprobante["Moneda"] = "MXN";
            $comprobante["TipoCambio"] = "1";
            $comprobante["Total"] = $ttnew;
            $comprobante["TipoDeComprobante"] = "I";
            $comprobante["MetodoPago"] = "PUE";
            $comprobante["LugarExpedicion"] = $cpemi;
            $comprobante["CfdiRelacionados"] = null;
            
            $emisor["Rfc"]=$rfcemi;
            $emisor["Nombre"]=$nombreemi;
            $emisor["RegimenFiscal"]=$regimenfiscalemi;
            $receptor["Rfc"] = $rfcrecept;
            $receptor["Nombre"] = $nombrerecept;
            $receptor["ResidenciaFiscalSpecified"] = false;
            $receptor["NumRegIdTrib"] = null;
            $receptor["UsoCFDI"] = $usocfdirecept;
            
            $comprobante["Emisor"] = $emisor; //nivel comprobante
            $comprobante["Receptor"] = $receptor;

            $traslado[0]["Base"] = $banew;
            $traslado[0]["Impuesto"] = "002";
            $traslado[0]["TipoFactor"] = "Tasa";
            $traslado[0]["TasaOCuota"] = "0.160000";
            $traslado[0]["Importe"] = $iva;
            
            $impuesto["Traslados"] = $traslado; //nivel traslado
            $impuesto["Retenciones"] = null; //nivel traslado
            
            $conceptos[0]["Impuestos"] = $impuesto; //nivel impuesto
            
            $conceptos[0]["InformacionAduanera"] = null;
            $conceptos[0]["CuentaPredial"] = null;
            $conceptos[0]["ComplementoConcepto"] = null;
            $conceptos[0]["Parte"] = null;
            $conceptos[0]["ClaveProdServ"] = $claprod;
            $conceptos[0]["NoIdentificacion"] = $noidentificacion;
            $conceptos[0]["Cantidad"] = $canew;
            $conceptos[0]["ClaveUnidad"] = "LTR";
            $conceptos[0]["Unidad"] = "Litros";
            $conceptos[0]["Descripcion"] = $denew;
            $conceptos[0]["ValorUnitario"] = $vunew;
            $conceptos[0]["Importe"] = $importe;    
         
            $comprobante["Conceptos"] = $conceptos; //nivel conceptos

            $ImpuestosTotales["Retenciones"] = null;
            $ImpuestosTotales["Traslados"][0]["Impuesto"] = "002";
            $ImpuestosTotales["Traslados"][0]["TipoFactor"] = "Tasa";
            $ImpuestosTotales["Traslados"][0]["TasaOCuota"] = "0.160000";
            $ImpuestosTotales["Traslados"][0]["Importe"] = $iva;
            $ImpuestosTotales["TotalImpuestosTrasladados"] = $iva;
            $comprobante["Impuestos"] = $ImpuestosTotales;
            
            
            $comprobante["SubTotal"] = $stnew;
            $comprobante["Total"] = $ttnew;
            
            $json = json_encode($comprobante);
            //dd($json);

        try{
          
            $basePath = storage_path('app/factura/'.$folionew.'/');
           
            $jsonIssuerStamp = jsonEmisionTimbrado::Set($params);
            $resultadoJson = $jsonIssuerStamp::jsonEmisionTimbradoV4($json);
            var_dump($resultadoJson);
            //$resultadoJson = self::jsonEmisionTimbradoV4($json);
            if($resultadoJson->status=="success"){
                
                //save CFDI
                $ruta=$basePath.$resultadoJson->data->uuid.".xml";
                file_put_contents($ruta, $resultadoJson->data->cfdi);
                //echo $resultadoJson->data->cfdi;
                //save QRCode
                $nombreyRuta = $resultadoJson->data->uuid.".png";
                imagepng(imagecreatefromstring(base64_decode($resultadoJson->data->qrCode)), $basePath.$nombreyRuta); 
                
        
                $facid = Facturas::where('folio', '=', $folionew)->value('id');
                $facturas = Facturas::findOrFail($facid);
                $facturas->serie = "CFDI-G".$facid;
                $facturas->sello = $resultadoJson->data->selloSAT; 
                $facturas->nocertificado = $resultadoJson->data->noCertificadoCFDI;
                $facturas->certificado = $resultadoJson->data->noCertificadoSAT;
                $facturas->folio = $folionew;
                $facturas->uuid = $resultadoJson->data->uuid;
                $facturas->fechatimbrado = $resultadoJson->data->fechaTimbrado;
                $facturas->sellocfd = $resultadoJson->data->selloCFDI;
                $facturas->id_emisor = $emisors;
                $facturas->archivoxml = $resultadoJson->data->uuid.'.xml';
                $facturas->archivopdf = $resultadoJson->data->uuid.'.pdf';
                $facturas->lugarexpedicion = $cpemi;
                $facturas->usocfdi = $usocfdirecept;
                $facturas->importe = $importe;
                $facturas->iva = $iva;
                $facturas->noidentificacion = $noidentificacion;
                $facturas->moneda = "MXN";
                $facturas->tipocambio = 1;
                $facturas->tipocombrobante = "I";
                $facturas->metodopago = "PUE";
                $facturas->Claveproserv = $noidentificacion;
                $facturas->claveunidad = "LTR";
                $facturas->descuentoD = 0;
                $facturas->estatus = 2;
                $facturas->save();
                
                //GENERADOR DE PDF***********************************************************************************************
                $idfactura=Facturas::where('folio', '=', $folionew)->value('id');
                $facturas = Facturas::findOrFail($idfactura);
                $estacion=Station::findOrFail($facturas->id_estacion);
                
                $QRcode = $resultadoJson->data->qrCode;
                $cadsat = $resultadoJson->data->cadenaOriginalSAT;
                
                $ruta = '../Catalogos/default/pdf/factura';
                $pdf = PDF::loadView($ruta, compact('facturas','cadsat', 'emisor', 'receptor'));
                $pdf->save(storage_path('app/factura/'.$folionew.'/') . $resultadoJson->data->uuid.".pdf");
                
    
                //CORREO ELECTRONICO --------------------------------------------------------------------------------------------------------------------------------------------------------
                $emailf= FacturaReceptor::where('id_user', '=', $facturas->id_receptor)->value('emailfiscal');
                
                        $nombre = "ricardo.resendiz@digitalsoft.mx";
                        $de = "ricardo.resendiz@digitalsoft.mx";
                        $asunto  = "Factura Electronica";
                        $para = [$nombre, $emailf]; 
                        $titulo = "Factura de combustible cargado";
                        
                       $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'titulo' => $titulo);
                       $pdfuid = $resultadoJson->data->uuid;
                       
                       Mail::send('mails.mailsfactura', $data, function($message) use($de, $para, $folionew, $pdfuid){
                       $message->from('ricardo.resendiz@digitalsoft.mx', 'Factura');
                       $message->subject('Factura');
                       $message->to($para);
                       $message->attach(storage_path('app/factura/'.$folionew.'/') . $pdfuid.".pdf");
                       });
           
                return true;
        
            }
            else{
                //save data error
                $ruta = $basePath."Error-".$comprobante["Folio"].".txt";
                $mensaje= $resultadoJson->message."\n".$resultadoJson->messageDetail;
                file_put_contents($ruta, $mensaje);
                var_dump($mensaje);
                 
                $facid = Facturas::where('folio', '=', $folionew)->value('id');
                $facturas = Facturas::findOrFail($facid);
                $facturas->lugarexpedicion = $cpemi;
                $facturas->usocfdi = $usocfdirecept;
                $facturas->importe = $importe;
                $facturas->estatus = 3;
                $facturas->save();
             
                //CORREO ELECTRONICO de Error--------------------------------------------------------------------------------------------------------------------------------------------------------
                $emailf= FacturaReceptor::where('id_user', '=', $facturas->id_receptor)->value('emailfiscal');
                
                        $nombre = "ricardo.resendiz@digitalsoft.mx";
                        $de = "ricardo.resendiz@digitalsoft.mx";
                        $asunto  = "Factura Electronica";
                        $para = "oestromerocerecedo@gmail.com"; 
                        $titulo = "Certificacion error".$folionew;
                        
                       $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'titulo' => $titulo);
                       
                       Mail::send('mails.mailsfactura', $data, function($message) use($de, $para, $folionew){
                       $message->from('ricardo.resendiz@digitalsoft.mx', 'Factura');
                       $message->subject('Certificacion error');
                       $message->to($para);
                       $message->attach(storage_path('app/factura/'.$folionew.'/') . "Error-".$folionew.".txt");
                       });
                       
                return false;
            }
            //var_dump($resultadoJson);
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
   
  }


  public function cambioservicio($id, $result)
  {
      
        $ticket = Facturas::find($id);
                 $ticket->estatus = $result;
                 $ticket->save();
     
  }
  
}
