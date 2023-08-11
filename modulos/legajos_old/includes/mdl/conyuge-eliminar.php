<form id="" action="?c=legajo&a=ConyugeEliminar" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="ConyugeEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="titulo"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <input type="hidden" class="form-control" id="hddapoderadoidn" name="hddapoderadoidn">
                <input type="hidden" class="form-control" id="hddjubiladoidn" name="hddjubiladoidn">
                <div class="row">
                <div class="col-xs-12 col-sm-12">

                    <div class="form-group">
                      <h4 class="modal-tittle">¿Seguro desea BORRAR el Conyuge?
                        <input type="text" class="form-control" id="hddnombre" name="hddnombre" disabled>
                    </div>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Borrar</button>
            </div>
          </div>
        </div>
      </div>
      </form>
