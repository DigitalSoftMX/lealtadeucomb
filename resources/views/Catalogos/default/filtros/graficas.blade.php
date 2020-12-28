<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Estaciones</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                          </button>
                        </div>
                        <form class="form" method="POST" action="{{ route('grapic') }}">
                         @csrf
                          <div class="modal-body">
                                <!--<div class="input-group form-control-lg">
                                    <label for="exampleInput1" class="col-sm-6">Fecha de inicio</label>
                                      <div class="form-group col-sm-8">
                                      <input type="date" class="form-control col-sm-12" id="min" name="min">
                                    </div>
                                   <label for="exampleInput1" class="col-sm-6">Fecha final</label>
                                      <div class="form-group col-sm-8">
                                      <input type="date" class="form-control col-sm-12" id="max" name="max">
                                    </div>
                                </div>-->
                                <div class="input-group form-control-lg">
                                    <div class="form-group col-sm-6">
                                      <label for="exampleInput1" class="bmd-label-floating">Estacion</label>
                                      <input type="text" class="form-control col-sm-12" id="id_estacion" name="station" style="width:100%">
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                          <input type="submit" class="btn btn-finish btn-fill btn-rose btn-wd" name="finish" value="Aceptar">
                          <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Cerrar</button>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>