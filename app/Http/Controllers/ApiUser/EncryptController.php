<?php

namespace App\Http\Controllers;

use App\Friend;
use App\Key;
use App\Mensaje;
use App\Usuarios;
use Illuminate\Http\Request;
use phpseclib\Crypt\RSA;
use Illuminate\Support\Facades\Crypt;
use mysqli;

class EncryptController extends Controller
{
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /* public function index(Request $request)
    { */
    public function index(){
        //Mensaje que se encripta con la llave publica del servidor
        /* Modo prueba que se usara en Android, no para E-GAS ni el proyecto facturacion
        Se trabaja en tener un encriptador y desencriptador generico */
        $mensaje = 'Hola, soy un mensaje que se encripta y desencripta';
        echo $this->encrypt($mensaje); 

        /* Mensaje encriptado que viene de JAVA (E-GAS) funcion para el proyecto Facturacion
        Funcionalidad php que si se usa en el servidor  */
        /* $mensaje=$this->decrypt("Q1U3LFdx6FCD2L3JOWNGMRVMJdxOdly2C7ZQcATTe1InNszgCgOFRWq9wiAP4iD0MWmosWwE6FmZgGk7seRxoS_B5HWanPm7uyTX/GLg03UI/MeafNw0Yc5pbtQHQDrqxLrQm2zWVUvaFZfQRT3NbqAWP1bvK4GLeTmXdrlWh3R5Ns2z5myTWnCsMq30WX135DBTngm9lWNXnQ2kuhZRd3oKg6jF0JBcvToiLrzfvLVWi5kcrH1kNXiOdLZhLAAEMRYdSg4WjIPmo37t2GiaXZghViLkYG/KYYKW5KKUKtZblZWkHbmZtLOi5PBjuFD2HDJ17xSlm0RYUK9p/ex_KQ==");
        echo $mensaje;  */
    }

    /* Metodo para general el par de llaves y guardarlas en la base de datos */
    public function generatePairKeys(){
        //configuracion para las llaves RSA
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        /* cabeceras y footers de las llaves privada y publica */
        $headerPrivateKey="-----BEGIN PRIVATE KEY-----\n";
        $footerPrivateKey="\n-----END PRIVATE KEY-----\n";
        $headerPublicKey="-----BEGIN PUBLIC KEY-----\n";
        $footerPublicKey="\n-----END PUBLIC KEY-----\n";
        /* Generando el par de llaves */
        $PairKeys=openssl_pkey_new($config);
        // Obteniendo la llave privada del servidor
        $privatekey="";
        openssl_pkey_export($PairKeys, $privatekey);
        //Reemplazando cabecera y footer de la llave privada
        $privatekey=str_replace($headerPrivateKey,"",$privatekey);
        $privatekey=str_replace($footerPrivateKey,"",$privatekey);
        /* $privatekey=str_replace("\n","-",$privatekey); */
        $privatekey=str_replace("\n","",$privatekey);
        echo "<br>LLAVE PRIVADA DEL SERVIDOR:   $privatekey<br>";
        // Obteniendo la llave publica del servidor
        $publickey=openssl_pkey_get_details($PairKeys);
        $publickey=$publickey["key"];
        //Reemplazando cabecera y footer de la llave publica
        $publickey=str_replace($headerPublicKey,"",$publickey);
        $publickey=str_replace($footerPublicKey,"",$publickey);
        /* $publickey=str_replace("\n","-",$publickey); */
        $publickey=str_replace("\n","",$publickey);
        echo "<br>LLAVE PUBLICA DEL SERVIDOR:   $publickey<br>";
        //Guardando la llave publica y privada dentro de la base de datos
        $keys=new Key();
        $keys->publickey=$publickey;
        $keys->privatekey=$privatekey;
        $keys->save();
    }

    /* Funcion para encriptar desede php, metodo de prueba para Android (no E-GAS) */

    private function encrypt($message){
        /* Obteniendo la llave publica de la base de datos */
        $key=Usuarios::find(3);
        $publickey=$key->publickey;
        /* Preparando la llave publica */
        $publickey = "-----BEGIN PUBLIC KEY-----\n" . wordwrap($publickey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
        /* Encriptando un mensaje */
        $cryptedText="";
        openssl_public_encrypt($message, $cryptedText, $publickey);
        $cryptedText=str_replace("+","_",base64_encode($cryptedText));
        return $cryptedText;
    }

    /* Metodo para desencriptar mensajes que vienen de JAVA
    los mensajes vienen de E-GAS */

    private function decrypt($message){
        /* Preparando el mensaje */
        $message=str_replace("_","+",$message);
        /* Obteniendo la llave privade de la base de datos */
        $key=Key::find(3);
        $privatekey=$key->privatekey;
        /* Preparando la llave privada */
        $privatekey = "-----BEGIN PRIVATE KEY-----\n" . wordwrap($privatekey, 64, "\n", true) . "\n-----END PRIVATE KEY-----";
        /* Desencriptando el mensaje */
        $decrypted="";
        $cryptedText=base64_decode($message);
        openssl_private_decrypt($cryptedText, $decrypted, $privatekey);
        /* Mensaje desencriptado */
        return $decrypted;
    }


    private function encriptador(){
        //headers y footers de las llaves privadas y publicas
        $headerPrivateKey="-----BEGIN PRIVATE KEY-----\n";
        $footerPrivateKey="\n-----END PRIVATE KEY-----\n";
        $headerPublicKey="-----BEGIN PUBLIC KEY-----\n";
        $footerPublicKey="\n-----END PUBLIC KEY-----\n";
        /* Llaves pares */
        $PairKeys=openssl_pkey_new();
        // Obteniendo la llave privada del servidor
        $privatekey="";
        openssl_pkey_export($PairKeys, $privatekey);
        //Reemplazando cabecera y footer de la llave privada
        $privatekey=str_replace($headerPrivateKey,"",$privatekey);
        $privatekey=str_replace($footerPrivateKey,"",$privatekey);
        $privatekey=str_replace("\n","-",$privatekey);
        echo "<br>LLAVE PRIVADA DEL SERVIDOR:   $privatekey<br>";
        // Obteniendo la llave publica del servidor
        $publickey=openssl_pkey_get_details($PairKeys);
        $publickey=$publickey["key"];
        //Reemplazando cabecera y footer de la llave publica
        $publickey=str_replace($headerPublicKey,"",$publickey);
        $publickey=str_replace($footerPublicKey,"",$publickey);
        $publickey=str_replace("\n","-",$publickey);
        echo "<br>LLAVE PUBLICA DEL SERVIDOR:   $publickey<br>";
        /* Mensaje a encriptar y desencriptar */
        $mensaje = 'Un mensaje que se encripta y desencripta';
        echo "<br>Mensaja a encriptar:  $mensaje<br>";
        //Concatenando cabecera y footer a la llave publica
        $publickey=str_replace("-","\n",$publickey);
        $publickey=$headerPublicKey.$publickey.$footerPublicKey;
        $crypttext="";
        /* Encriptando el mensaje */
        openssl_public_encrypt($mensaje, $crypttext, $publickey);
        $crypttext=base64_encode($crypttext);
        /* Mensaje encriptado */
        echo "<br>Mensaje encriptado:   $crypttext<br>";
        /* Desencriptando el mensaje */
        $privatekey=str_replace("-","\n",$privatekey);
        $privatekey=$headerPrivateKey.$privatekey.$footerPrivateKey;
        $decrypted="";
        $crypttext=base64_decode($crypttext);
        openssl_private_decrypt($crypttext, $decrypted, $privatekey);
        /* Mensaje desencriptado */
        echo "<br>Mensaje desencriptado:    $decrypted<br>";
    }

    private function randomNumber($array,$number){
        foreach($array as $num){
            if($num->nocount==$number){
                return true;
            }
        }
        return false;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /* return '{"response":"200 ok"}'; */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
