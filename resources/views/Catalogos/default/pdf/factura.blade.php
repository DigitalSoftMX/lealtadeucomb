<div id="pdf">
    <table border="0" style="width: 100%;">
        <tr>
            <td class="columnaUno centrar" colspan="6">
                <div>
                    <p class="tituloUno bold">{{$facturas['serie']}}</p>
                </div>
                <div class="tituloDos ">
                    RFC: {{$emisor['Rfc']}}
                </div>
                <div class="tituloDos ">
                    NO. ESTACIÓN: 
                </div>
                <div class="tituloTres ">
                    REGIMEN FISCAL: {{$emisor['RegimenFiscal']}}
                </div>
                <div class="tituloTres ">
                    ACTIVIDADES EMPRESARIALES Y PROFESIONALES
                </div>
                <div class="tituloDos ">
                    CP DE EXPEDICIÓN: {{$facturas['lugarexpedicion']}}
                </div>
            </td>
            <td class="columnaDos centrar" colspan="3">
                <div class="gray bold tituloDos">
                    Serie - Factura No.
                </div>
                <div class="bold tituloUno">
                    {{$facturas['serie']}}
                </div>
                <div class="gray bold tituloDos">
                    Folio fiscal
                </div>
                <div class="bold tituloDos">
                    {{$facturas['uuid']}}
                </div>
                <div class="gray bold tituloDos">
                    Fecha emisión
                </div>
                <div class="tituloDos">
                    {{$facturas['fecha']}}
                </div>
                <div class="gray bold tituloDos">
                    Fecha certificación
                </div>
                <div class="tituloDos">
                    {{$facturas['fechatimbrado']}}
                </div>
                <div class="gray bold tituloDos">
                    No. Certificado Digital
                </div>
                <div class="tituloDos">
                    {{$facturas['nocertificado']}}
                </div>
                <div class="gray bold tituloDos">
                    No. Certificado Digital Sat
                </div>
                <div class="tituloDos">
                    {{$facturas['certificado']}}
                </div>
            </td>
        </tr>
        <tr>
            <td class="gray bold tituloDos" colspan="9">
                Receptor
            </td>
        </tr>
        <tr>
            <td class="tituloDos" colspan="9">
                RFC: {{$receptor['Rfc']}}
            </td>
        </tr>
        <tr>
            <td class="tituloDos" colspan="9">
                RAZON SOCIAL: {{$receptor['Nombre']}}
            </td>
        </tr>
        <tr>
            <td class="tituloDos" colspan="9">
                USO CFDI: {{$receptor['UsoCFDI']}}
            </td>
        </tr>
        <tr>
            <td class="gray bold tituloDos">
                Cve. Prod/Serv
            </td>
            <td class="gray bold tituloDos">
                Cve. Unidad
            </td>
            <td class="gray bold tituloDos">
                No. Ident
            </td>
            <td class="gray bold tituloDos">
                Unidad
            </td>
            <td class="gray bold tituloDos">
                Cantidad
            </td>
            <td class="gray bold tituloDos">
                Descripción
            </td>
            <td class="gray bold tituloDos">
                Valor unitario
            </td>
            <td class="gray bold tituloDos">
                Descuento
            </td>
            <td class="gray bold tituloDos">
                Importe
            </td>
        </tr>
        <tr>
            <td class="tituloDos">
                {{$facturas['Claveproserv']}}
            </td>
            <td class="tituloDos">
                {{$facturas['claveunidad']}}
            </td>
            <td class="tituloDos">
                {{$facturas['noidentificacion']}}
            </td>
            <td class="tituloDos">
                Litros
            </td>
            <td class="tituloDos">
                ${{$facturas['cantidad']}}
            </td>
            <td class="tituloDos">
                {{$facturas['descripcion']}}
            </td>
            <td class="tituloDos">
                ${{$facturas['valorunitario']}}
            </td>
            <td class="tituloDos">
                $0
            </td>
            <td class="tituloDos">
                ${{$facturas['importe']}}
            </td>
        </tr>
        <tr>
            <td colspan="3">
            </td>
            <td class="gray bold tituloDos">
                Tipo Impuesto
            </td>
            <td class="gray bold tituloDos">
                Base
            </td>
            <td class="gray bold tituloDos">
                Impuesto
            </td>
            <td class="gray bold tituloDos">
                Tipo factor
            </td>
            <td class="gray bold tituloDos">
                Tasa/Cuota
            </td>
            <td class="gray bold tituloDos">
                Importe
            </td>
        </tr>
        <tr>
            <td colspan="3">
            </td>
            <td class="tituloDos">
                Trasladado
            </td>
            <td class="tituloDos">
                {{$facturas['base']}}
            </td>
            <td class="tituloDos">
                002-IVA
            </td> 
            <td class="tituloDos">
                Tasa
            </td>
            <td class="tituloDos">
                0.160000
            </td>
            <td class="tituloDos">
                ${{$facturas['iva']}}
            </td>
        </tr>
        <tr>
            <td colspan="7"></td>
            <td>
                <div class="bold tituloDos">
                    SUBTOTAL
                </div>
                <div class="bold tituloDos">
                    IVA a 16%
                </div>
                <div class="bold tituloDos">
                    TOTAL
                </div>
            </td>
            <td>
                <div class="tituloDos">
                    ${{$facturas['subtotal']}}
                </div>
                <div class="tituloDos">
                    ${{$facturas['iva']}}
                </div>
                <div class="tituloDos">
                    ${{$facturas['total']}}
                </div>
            </td>
        </tr>
        {{-- <tr>
            <td class="gray bold tituloDos" colspan="9">
                Importe con letra
            </td>
        </tr>
        <tr>
            <td colspan="9" class="tituloDos">
                
            </td>
        </tr> --}}
        <tr>
            <td class="gray bold tituloDos" colspan="2">
                Tipo de comprobante
            </td>
            <td class="gray bold tituloDos" colspan="2">
                Moneda
            </td>
            <td class="gray bold tituloDos">
                Tipo cambio
            </td>
            <td class="gray bold tituloDos" colspan="2">
                Forma de pago
            </td>
            <td class="gray bold tituloDos" colspan="2">
                Método de pago
            </td>
        </tr>
        <tr>
            <td colspan="2" class="tituloDos">
                {{$facturas['tipocombrobante']}}
                {{-- {{$facturas['tipocomprobante']}}-Ingreso --}}
            </td>
            <td colspan="2" class="tituloDos">
                {{$facturas['moneda']}}
            </td>
            <td class="tituloDos">
                -
            </td>
            <td colspan="2" class="tituloDos">
                {{$facturas['formapago']}}
            </td>
            <td colspan="2" class="tituloDos">
                {{$facturas['metodopago']}}
                {{-- {{$facturas['metodopago']}} --}}
            </td>
        </tr>
        <tr>
            <td class="gray bold tituloDos" colspan="9">
                Cadena original del complemento de certificacion digital del SAT
            </td>
        </tr>
        <tr>
            <td class="justificado" colspan="9">
            {{--    {{$cadsat}} --}}
               
                <?php
                    $cadena = '';
                    for ($i = 0; $i < strlen($cadsat); $i++) {
                        if ($i % 9 == 0) {
                            $cadena .= ' '.$cadsat[$i];
                        } else {
                            $cadena .= $cadsat[$i];
                        }
                    }
                    echo $cadena;
                ?>
                    
            </td>
        </tr>
        <tr>
            <td class="centrar" colspan="4">
                <img src="../storage/app/factura/{{$facturas['folio']}}/{{$facturas['uuid']}}.png" width="200px" height="200px" />
            </td>
            <td colspan="5">
                <div class="gray bold tituloDos">
                    Sello Digital
                </div>
                <div class="justificado tituloDos">
                    
                    {{--    {{$facturas['sello']}}  --}}
                    
                    <?php
                        $cadena = '';
                        for ($i = 0; $i < strlen($facturas['sello']); $i++) {
                            if ($i % 9 == 0) {
                                $cadena .= ' '.$facturas['sello'][$i];
                            } else {
                                $cadena .= $facturas['sello'][$i];
                            }
                        }
                        echo $cadena;
                    ?>
                </div>
                <div class="gray bold tituloDos">
                    Sello Digital SAT
                </div>
                <div class="justificado tituloDos">
                    
                    {{--    {{$facturas['sellocfd']}}   --}}
                    
                    <?php
                        $cadena = '';
                        for ($i = 0; $i < strlen($facturas['sellocfd']); $i++) {
                            if ($i % 9 == 0) {
                                $cadena .= ' '.$facturas['sellocfd'][$i];
                            } else {
                                $cadena .= $facturas['sellocfd'][$i];
                            }
                        }
                        echo $cadena;
                    ?>
                </div>
            </td>
        </tr>
    </table>

    <style>
        table {
            font-family: Arial, Helvetica, sans-serif;
        }

        .columnaUno {
            width: 60%;
        }

        .columnaDos {
            width: 40%;
        }

        .gray {
            background-color: #BDBDBD;
        }

        .centrar {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .tituloUno {

            font-size: 15px;
        }

        .tituloDos {

            font-size: 12px;
        }

        .tituloTres {

            font-size: 9px;
        }

        .justificado {
            font-size: 11px;
            text-align: justify;
        }

    </style>

</div>
