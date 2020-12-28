<?php namespace App\Http\Controllers\Catalogos\Lealtad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Util\CatalogTrait;

class MovementController extends Controller {

    use CatalogTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->field_list = ['number_usuario'=>'QR Membresía','generado'=>'QR Despachador','number_ticket'=>'QR Ticket','punto'=>'Puntos','litro'=>'Litros', 'producto'=>'Producto','name'=>'Nombre','descrip'=>'Concepto','created_at'=>'Fecha'];
        $this->name = 'Movimiento';
        $this->name_plural = 'fa fa-file-text-o';
        $this->form = 'App\Core\Forms\Lealtad\AdminMovementForm';
        $this->model = 'App\Models\Lealtad\Tickets';
        $this->url_prefix = 'movement';
        $validation_add = [
      /*      'qr_memberships'=>'required|max:25',
            'qr_dispatcher'=>'required|max:25',
            'folio'=>'required|max:25',
       */ ];
        $validation_edit = $validation_add;
        $this->setValidatorAdd($validation_add);
        $this->setValidatorEdit($validation_edit);

    }

}