<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Paquete de Timbres</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="myform" method="post" action="" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')
          
          <div class="modal-body">
                  @foreach ($precios as $precio)
                               <div class="row">
                                <div class="col-sm-12 checkbox-radios">
                                  <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="radio" name="timbres" value="{{$precio->id}}">Precio: ${{$precio->costo}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Timbres:{{$precio->num_ticket}}
                                      <span class="circle">
                                        <span class="check"></span>
                                      </span>
                                    </label>
                                  </div>
                                </div>
                               </div>
                  @endforeach
         </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>

@push('js')
<script>
    function tipo(variable){
       $("#myform").attr("action","https://eucomb.lealtaddigitalsoft.mx/catestaciones/pac/"+""+variable+"");
   }
</script>
@endpush
