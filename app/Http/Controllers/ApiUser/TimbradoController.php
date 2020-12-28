<?php

namespace App\Http\Controllers\ApiUser;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\Role_User;
use App\Models\Catalogos\CatFacturas;
use App\Models\Catalogos\CatEstaciones;
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


class TimbradoController extends Controller
{
  public function timbrar()
  {
      
    $verifica = Facturas::where('estatus', '=', 1)->get();

    if ($verifica != null) {
    
      foreach($verifica as $veri){
          $folionew = $veri->serie;
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
      }    
        $empresa = CatEstaciones::where('numero', '=', $esnew)->value('id_empresa');
        $emisor = Empresas::where('id', '=', $empresa)->value('id_user');
         
            $result = self::sendcfdi($emisor, $receptor, $folionew, $fpnew, $stnew, $ttnew, $denew, $vunew, $canew, $esnew, $bonew, $fhnew, $banew);
      
            if ($result == true) {
              $facturas = facturas::latest()->get();
              $result = self::pdf($facturas[0]->id, $facturas[0]->serie);
              if ($result) {
                \DB::table('empresas')->where('id', "=", $empresa)->increment('total_facturas', 1);
                \DB::table('cat_estaciones')->where('id', "=", $esnew)->increment('total_facturas', 1);
                $respuesta = json_encode(array('resultado' => "La informacion se actualizo correctamente"));
              }else{
                $result = "El pac no conecto";
                self::cambioservicio($facturas[0]->id, $result);
                $respuesta = json_encode(array('resultado' => "Ha ocurrido un error al actualizar la informacion"));
              }
            } else {
                 $result = self::sendcfdi($emisor, $receptor, $folionew, $fpnew, $stnew, $ttnew, $denew, $vunew, $canew, $esnew, $bonew, $fhnew, $banew);
                   //****************************************************************************************************************
                        if ($result == true) {
                          $facturas = facturas::latest()->get();
                          $result = self::pdf($facturas[0]->id, $facturas[0]->serie);
                          if ($result) {
                            \DB::table('empresas')->where('id', "=", $empresa)->increment('total_facturas', 1);
                            \DB::table('cat_estaciones')->where('id', "=", $esnew)->increment('total_facturas', 1);
                            $respuesta = json_encode(array('resultado' => "La informacion se actualizo correctamente"));
                          }else{
                            $result = "El pac no conecto";
                            self::cambioservicio($facturas[0]->id, $result);
                            $respuesta = json_encode(array('resultado' => "Ha ocurrido un error al actualizar la informacion"));
                          }
                        } else {
                             $result = self::sendcfdi($emisor, $receptor, $folionew, $fpnew, $stnew, $ttnew, $denew, $vunew, $canew, $esnew, $bonew, $fhnew, $banew);
                             //---------------------------------------------------------------------------------------------------------------------------
                             
                                if ($result == true) {
                                  $facturas = facturas::latest()->get();
                                  $result = self::pdf($facturas[0]->id, $facturas[0]->serie);
                                  if ($result) {
                                    \DB::table('empresas')->where('id', "=", $empresa)->increment('total_facturas', 1);
                                    \DB::table('cat_estaciones')->where('id', "=", $esnew)->increment('total_facturas', 1);
                                    $respuesta = json_encode(array('resultado' => "La informacion se actualizo correctamente"));
                                  }else{
                                    $result = "El pac no conecto";
                                    self::cambioservicio($facturas[0]->id, $result);
                                    $respuesta = json_encode(array('resultado' => "Ha ocurrido un error al actualizar la informacion"));
                                  }
                                } else {
                                   $result = "El sistema no creo el cfdi o xml";
                                   self::cambioservicio($facturas[0]->id, $result);
                                   $respuesta = json_encode(array('resultado' => "Error no se creo el cfdi"));
                                    // $result = self::sendcfdi($emisor, $receptor, $folionew, $fpnew, $stnew, $ttnew, $denew, $vunew, $canew, $esnew, $bonew, $fhnew, $banew);
                                }
                             //---------------------------------------------------------------------------------------------------------------------------
                        }
                   //****************************************************************************************************************
            }
          }
        
     else {
      $respuesta = json_encode(array('resultado' => 'No hay facturas que enviar'));
    }
    //*************************************************************************************************************************                            

    return response($respuesta);
    //return response()->json($beneficios);

  }

  public function sendcfdi($emisor, $receptor, $folionew, $fpnew, $stnew, $ttnew, $denew, $vunew, $canew, $esnew, $bonew, $fhnew, $banew)
  {
    //Creando carpeta con el numero de folio
    Storage::makeDirectory('factura/' . $folionew);
    //CONSULTAR DATOS DE EMISOR
    $datosReceptor = FacturaReceptor::where('id_user', '=', $receptor)->get();
    foreach ($datosReceptor as $dr) {
      $nombrerecept = $dr->nombre;
      $rfcrecept = $dr->rfc;
      $usocfdirecept = $dr->usocfdi;
      $emailfiscalrecept = $dr->emailfiscal;
    }
     //CONSULTAR DATOS DEL RECEPTOR
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
      $cuenta = $em->cuenta;
      $pass = $em->pass;
      $user = $em->user;
    }
     
        
     $importes = (($canew) * ($vunew));
     $importe = $stnew;
     $iva = (($ttnew) - ($stnew));
     
     if($denew == "Diesel"){ $claprod = "15101513"; } 
                else if($denew == "Premium"){ $claprod = "15101514"; } 
                       else{ $claprod = "15101515"; }
         
     //Encabezado del XML para la peticiòn SOAP
   $soap_request  = "<?xml version=\"1.0\"?>\n";
   $soap_request .= "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:tem=\"http://tempuri.org/\" xmlns:tes=\"http://schemas.datacontract.org/2004/07/TES.V33.CFDI.Negocios\">\n";  
   $soap_request .= "<soapenv:Header/>\n";
   $soap_request .= "<soapenv:Body>\n";
   $soap_request .= "<tem:GenerarCFDI>\n";
  
   $soap_request .= "    <tem:credenciales>\n";
   $soap_request .= "    <tes:Cuenta>$cuenta</tes:Cuenta>\n";
   $soap_request .= "    <tes:Password>$pass</tes:Password>\n";
   $soap_request .= "    <tes:Usuario>$user</tes:Usuario>\n";
   $soap_request .= "    </tem:credenciales>\n";
  
  // Sección de variables para agregar los valores al comprobante CFDi.
  //*************************************************************************************
  $soap_request .= "    <tem:cfdi>\n";
  $soap_request .= "    <tes:ClaveCFDI>FAC</tes:ClaveCFDI>\n";
  
  //Inidica el concepto a facturar con su impuesto correspondiente.
  $soap_request .= "    <tes:Conceptos>\n";
  $soap_request .= "    <tes:ConceptoR>\n";
  $soap_request .= "    <tes:Cantidad>$canew</tes:Cantidad>\n";
  $soap_request .= "    <tes:ClaveProdServ>$claprod</tes:ClaveProdServ>\n";
  $soap_request .= "    <tes:ClaveUnidad>LTR</tes:ClaveUnidad>\n";
  $soap_request .= "    <tes:Descripcion>$denew</tes:Descripcion>\n";
  $soap_request .= "    <tes:Importe>$stnew</tes:Importe>\n";
  $soap_request .= "    <tes:Impuestos>\n";
  $soap_request .= "    <tes:Traslados>\n";
  $soap_request .= "    <tes:TrasladoConceptoR>\n";
  $soap_request .= "    <tes:Base>$banew</tes:Base>\n";
  $soap_request .= "    <tes:Importe>$iva</tes:Importe>\n";
  $soap_request .= "    <tes:Impuesto>002</tes:Impuesto>\n";
  $soap_request .= "    <tes:TasaOCuota>0.160000</tes:TasaOCuota>\n";
  $soap_request .= "    <tes:TipoFactor>Tasa</tes:TipoFactor>\n";
  $soap_request .= "    </tes:TrasladoConceptoR>\n";
  $soap_request .= "    </tes:Traslados>\n";
  $soap_request .= "    </tes:Impuestos>\n";
  $soap_request .= "    <tes:NoIdentificacion>$folionew</tes:NoIdentificacion>\n";
  $soap_request .= "    <tes:Unidad>LITROS</tes:Unidad>\n";
  $soap_request .= "    <tes:ValorUnitario>$vunew</tes:ValorUnitario>\n";
  $soap_request .= "    </tes:ConceptoR>\n";
  $soap_request .= "    </tes:Conceptos>\n";

  //Variable condiciones de pago.
  $soap_request .= "    <tes:CondicionesDePago>CONDICIONES</tes:CondicionesDePago>";
  
  //Datos del emisor del comprobante.
  $soap_request .= "  <tes:Emisor>\n";
  $soap_request .= "    <tes:Nombre>$nombreemi</tes:Nombre>\n";
  $soap_request .= "    <tes:RegimenFiscal>$regimenfiscalemi</tes:RegimenFiscal>\n";
  $soap_request .= "    </tes:Emisor>\n";
  
  //Variables generales del comprobante.
  $soap_request .= "    <tes:FormaPago>$fpnew</tes:FormaPago>\n";
  $soap_request .= "    <tes:LugarExpedicion>$cpemi</tes:LugarExpedicion>\n";
  $soap_request .= "    <tes:MetodoPago>PUE</tes:MetodoPago>\n";
  $soap_request .= "    <tes:Moneda>MXN</tes:Moneda>\n";
  
  //Datos del receptor del comprobante.
  $soap_request .= "    <tes:Receptor>\n";   
  $soap_request .= "    <tes:Nombre>$nombrerecept</tes:Nombre>\n";
  $soap_request .= "    <tes:Rfc>$rfcrecept</tes:Rfc>\n";
  $soap_request .= "    <tes:UsoCFDI>$usocfdirecept</tes:UsoCFDI>\n";
  $soap_request .= "    </tes:Receptor>\n";
  
  //Referencia única e importes finales del comrprobante.
  $soap_request .= "    <tes:Referencia>$folionew</tes:Referencia>\n";
  $soap_request .= "    <tes:SubTotal>$stnew</tes:SubTotal>\n";
  $soap_request .= "    <tes:Total>$ttnew</tes:Total>\n";
  $soap_request .= "    </tem:cfdi>\n";
  $soap_request .= "    </tem:GenerarCFDI>\n";
  $soap_request .= "    </soapenv:Body>\n";
  $soap_request .= "    </soapenv:Envelope>\n";
 
    
  //creo un archivo soap_reequest.xml e introduzco la cadena_xml
      $new_xml = fopen ("../storage/app/factura/$folionew/$folionew-request.xml", "w");
  fwrite($new_xml,$soap_request);
  fclose($new_xml);


  $header = array(
    "POST /CR33Test/ConexionRemota.svc HTTP/1.1",
  "Host: www.fel.mx",
  "Content-Type: text/xml; charset=UTF-8",
  "Content-Length: ".strlen($soap_request),
  "SOAPAction: \"http://tempuri.org/IConexionRemota/GenerarCFDI\""
  );
  
  
//Parametros de la conexion al webservice y URL del servicio
  $soap_do = curl_init();
  curl_setopt($soap_do, CURLOPT_URL, "https://app.factureyapac.com/CR33Test/ConexionRemota.svc?WSDL");
  curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30);
  curl_setopt($soap_do, CURLOPT_TIMEOUT,        30);
  curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
  curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($soap_do, CURLOPT_POST,           true );
  curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $soap_request);
  curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

  // Respuesta del webservice
            $response = curl_exec($soap_do); 
            curl_close($soap_do);
  //print $response;
  //se guarda del web service (Tipo de Respuesta, XML Timbrado y CBB)     
  $new_xml = fopen ("../storage/app/factura/$folionew/$folionew-response.xml", "w");
  fwrite($new_xml, $response);
  fclose($new_xml);
  
        $facid = Facturas::where('serie', '=', $folionew)->value('id');
        $facturas = Facturas::findOrFail($facid);
        $facturas->lugarexpedicion = $cpemi;
        $facturas->usocfdi = $usocfdirecept;
        $facturas->importe = $importe;
        $facturas->estatus = 1;
        $facturas->save();

   if($response == false){
       return false;   
   }
   else{
       return true;
   }
    
  }

  public function pdf($id, $folio)
  {
    $archivoXML = fopen("../storage/app/factura/$folio/$folio-response.xml", "r");
    $lectura = '';
    while (!feof($archivoXML)) {
      $lectura = fgets($archivoXML);
    }
    fclose($archivoXML);

    if ($lectura != '') {
      $arraryLectura = explode("<", $lectura);
      $xmlCFDI = substr($arraryLectura[16], 6);
      $fixXML = str_replace("&lt;", "<", $xmlCFDI);
      $fixXML = str_replace("&gt;", ">", $fixXML);
      $xml = simplexml_load_string($fixXML);
      $ns = $xml->getNamespaces(true);
      $xml->registerXPathNamespace('cfdi', $ns['cfdi']);
      $xml->registerXPathNamespace('t', $ns['tfd']);

      $datosComprobante = array();
      $datosEmisor = array();
      $datosReceptor = array();
      $datosConcepto = array();
      $datosTraslado = array();
      $timbreFiscalDigital = array();

      foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante) {
        array_push($datosComprobante, $cfdiComprobante['Version']); // 0
        array_push($datosComprobante, $cfdiComprobante['Serie']); // 1
        array_push($datosComprobante, $cfdiComprobante['Folio']); // 2
        array_push($datosComprobante, $cfdiComprobante['Fecha']); // 3
        array_push($datosComprobante, $cfdiComprobante['Sello']); // 4
        array_push($datosComprobante, $cfdiComprobante['FormaPago']); // 5
        array_push($datosComprobante, $cfdiComprobante['NoCertificado']); // 6
        array_push($datosComprobante, $cfdiComprobante['Certificado']); // 7
        array_push($datosComprobante, $cfdiComprobante['SubTotal']); // 8
        array_push($datosComprobante, $cfdiComprobante['Moneda']); // 9
        array_push($datosComprobante, $cfdiComprobante['Total']); // 10
        array_push($datosComprobante, $cfdiComprobante['TipoDeComprobante']); // 11
        array_push($datosComprobante, $cfdiComprobante['MetodoPago']); // 12
        array_push($datosComprobante, $cfdiComprobante['LugarExpedicion']); // 13
      }

      foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor) {
        array_push($datosEmisor, $Emisor['Rfc']); //0
        array_push($datosEmisor, $Emisor['Nombre']); //1
        array_push($datosEmisor, $Emisor['RegimenFiscal']); //2
      }

      foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor) {
        array_push($datosReceptor, $Receptor['Rfc']); //0
        array_push($datosReceptor, $Receptor['Nombre']); //1
        array_push($datosReceptor, $Receptor['UsoCFDI']); //2
      }

      foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto) {
        array_push($datosConcepto, $Concepto['ClaveUnidad']); //0
        array_push($datosConcepto, $Concepto['ClaveProdServ']); //1
        array_push($datosConcepto, $Concepto['NoIdentificacion']); //2
        array_push($datosConcepto, $Concepto['Cantidad']); //3
        array_push($datosConcepto, $Concepto['Unidad']); //4
        array_push($datosConcepto, $Concepto['Descripcion']); //5
        array_push($datosConcepto, $Concepto['ValorUnitario']); //6
        array_push($datosConcepto, $Concepto['Importe']); //7
      }

      foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado) {
        array_push($datosTraslado, $Traslado['Impuesto']); //0
        array_push($datosTraslado, $Traslado['TipoFactor']); //1
        array_push($datosTraslado, $Traslado['TasaOCuota']); //2
        array_push($datosTraslado, $Traslado['Importe']); //3
        array_push($datosTraslado, $Traslado['Base']); //4
      }

      foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
        array_push($timbreFiscalDigital, $tfd['Version']); //0
        array_push($timbreFiscalDigital, $tfd['RfcProvCertif']); //1
        array_push($timbreFiscalDigital, $tfd['UUID']); //2
        array_push($timbreFiscalDigital, $tfd['FechaTimbrado']); //3
        array_push($timbreFiscalDigital, $tfd['SelloCFD']); //4
        array_push($timbreFiscalDigital, $tfd['NoCertificadoSAT']); //5
        array_push($timbreFiscalDigital, $tfd['SelloSAT']); //6
      }

      //Verificando que datos necesarios para construccion de pdf
      if (!empty($datosComprobante[4]) && !empty($datosComprobante[6]) && !empty($datosComprobante[7]) & !empty($timbreFiscalDigital[2]) && !empty($timbreFiscalDigital[3]) && !empty($timbreFiscalDigital[4]) && !empty($timbreFiscalDigital[5]) && !empty($timbreFiscalDigital[6])) {
        $facturas = Facturas::findOrFail($id);
        $facturas->fecha = $datosComprobante[3];
        $facturas->sello = $datosComprobante[4];
        $facturas->nocertificado = $datosComprobante[6];
        $facturas->moneda = $datosComprobante[9];
        $facturas->tipocombrobante = $datosComprobante[11];
        $facturas->metodopago = $datosComprobante[12];
        $facturas->usocfdi = $datosReceptor[2];
        $facturas->Claveproserv = $datosConcepto[1];
        $facturas->claveunidad = $datosConcepto[0];
        $facturas->importe = $datosConcepto[7];
        $facturas->certificado = $datosComprobante[7];
        
        $facturas->folio=$datosComprobante[2];
        $facturas->uuid=$timbreFiscalDigital[2];
        $facturas->fechatimbrado=$timbreFiscalDigital[3];
        $facturas->sellocfd=$timbreFiscalDigital[4];
        
        $facturas->archivoxml = "$folio-response.xml";
        $facturas->archivopdf = "$folio.pdf";
        
        $facturas->estatus = 2;
        $facturas->save();

        //GENERADOR DE QR IMAGEN
          /* $datosComprobante[4] = json_encode($datosComprobante[4]);
          $datosComprobante[4] = str_replace('{"0":"', "", $datosComprobante[4]);
          $datosComprobante[4] = str_replace('"}', "", $datosComprobante[4]); */
          
          $link="https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=ADF55BBC-F9EF-445A-B9BF-0A1B62F8A27E&re=HEFF530711R21&rr=RMP010402FH3&tt=0000001033.850000&fe=DgjPCA==";
          $Base64Img = 'data:image/png;base64, ' . DNS2D::getBarcodePNG($link, 'QRCODE') . ' ';
          
        list(, $Base64Img) = explode(';', $Base64Img);
        list(, $Base64Img) = explode(',', $Base64Img);
        $Base64Img = base64_decode($Base64Img);
        file_put_contents("../storage/app/factura/$folio/$folio.jpg", $Base64Img);

        //comienza construccion del pdf
        
        $idfactura=Facturas::where('serie', '=', $folio)->value('id');
        $facturas = Facturas::findOrFail($idfactura);
        $estacion=CatEstaciones::findOrFail($facturas->id_estacion);
        
        $ruta = '../Catalogos/default/pdf/factura';
        $pdf = PDF::loadView($ruta, compact('datosComprobante', 'datosEmisor', 'datosReceptor', 'datosConcepto', 'datosTraslado', 'timbreFiscalDigital','folio','facturas','estacion'));
        $pdf->save(storage_path("app/factura/$folio/") . "$folio.pdf");
        //echo 'pdf generado';
        $emailf= FacturaReceptor::where('id_user', '=', $facturas->id_receptor)->value('emailfiscal');
        
                        $nombre = "ricardo.resendiz@digitalsoft.mx";
                        $de = "ricardo.resendiz@digitalsoft.mx";
                        $asunto  = "Factura Electronica";
                        $para = [$nombre, $emailf]; 
                        $titulo = "Factura de combustible cargado";
                        
                       $data = array( 'de' => $de, 'para' => $para, 'asunto' => $asunto, 'nombre' => $nombre, 'titulo' => $titulo);
        
                       Mail::send('mails.mailsfactura', $data, function($message) use($de, $para){
                       $message->from('ricardo.resendiz@digitalsoft.mx', 'Factura');
                       $message->subject('Factura');
                       $message->to($para);
                       $message->attach(storage_path("app/factura/100003/") . "100003.pdf");
                       });
        return true;
      } else {
        //echo 'Error hay datos faltantes';
        return false;
      }
    } else {
      //Actualizacion de registro, 0 = no hay respuesta del servidor, 1 si hay respuesta y se puede crear el pdf
      $facturas = Facturas::findOrFail($id);
      $facturas->estatus = 0;
      $facturas->save();
      //echo 'Hay un error, no hubo respuesta del servidor';
      return false;
    }
  }
  
  public function cambioservicio($id, $result)
  {
      
        $ticket = Facturas::find($id);
                 $ticket->estatus = $result;
                 $ticket->save();
     
  }
  
}
