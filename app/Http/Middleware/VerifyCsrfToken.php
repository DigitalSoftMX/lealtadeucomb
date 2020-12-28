<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'apisuser*',
        'entregaexchangejfilter*',
       'historyjfilter*',
       'apiqrformulario*',
       'apistation1*',
       'apiagregarpremioios*',
       'apiexchangedisponiblesios*',
       'apiexchangeios*',
       'apiexchangepremiosios*',
       'apiexchangedisponiblespremiosios*',
       'apipremioios*',
       'apiagregarvaleios*',
       'apivale*',
       'apiestadocuentafacturaios*',
       'apimembresiaios*',
       'apimembresiaestadocuentaios*',
       'apiexchangedisponiblespremios*',
       'apiexchangepremios*',
       'apiagregarpremio*',
       'apipremioestacion*',
       'apipremio*',
       'apisticket*',
       'apiexchange*',
       'apiagregarvale*',
       'apiexchangedisponibles*',
       'apivale*',
       'apimovimientos*',
       'apipuntos*',
       'apimembresiaestadocuenta*',
       'apimembresia*',
       'cobrarexchangejfilter*',
       'entregarexchangejfilter*',
       'procesoexchangejfilter*',
       'movementjfilter*',
       'userclientjfilter*',
       'notification*',
       'apitimbrar*',
       'apivisual*',
       'password*',
       'apiestacionesios*',
       'apiestaciones*',
       'apiestadocuentaios*',
       'apiestadocuenta*',
       'apidatosfacturaupdate*',
       'apidatosfactura*',
       'apidatosfacturaios*',
       'apiregistrar*',
       'apicerrar*',
       'apilogin*',
       'apiperfil*',
       'apiperfilios*',
       'apiperfilupdate*',
       'apis/v1*',

    ];
}
