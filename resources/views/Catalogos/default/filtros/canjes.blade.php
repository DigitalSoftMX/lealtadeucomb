                  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Solicitar Vale</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                          </button>
                        </div>
                        <form action="{{route('agregarvales',$user[0]->id)}}" autocomplete="off" class="form-horizontal" method="post" enctype="multipart/form-data">
                          @csrf
                          @method('post')
                          <div class="modal-body">
                                <div class="input-group form-control-lg">
                                    <div class="form-group col-sm-12">
                                      <input type="text" class="form-control col-sm-12" id="id_station" name="id_station" style="width:100%" required>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                          <input type="submit" class="btn btn-finish btn-fill btn-rose btn-wd" name="finish" value="Guardar">
                          <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Cerrar</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>