<form id="#" action="?c=empleado&a=PreNatalGuardar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="dataUpdatePreNatal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" name="hddprenatalid" id="hddprenatalid">
          <input type="hidden" class="form-control" name="empid" id="empid">
          <input type="hidden" class="form-control" name="empnrodocto" id="empnrodocto">
          <input type="hidden" class="form-control" name="bennrodocto" id="bennrodocto">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtprenatalfecum" class="control-label">Fecha UM: </label>
                <input type="date" name="txtprenatalfecum" id="txtprenatalfecum" class="form-control form-control-sm">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtprenatalfecpp" class="control-label">Fecha PP: </label>
                <input type="date" name="txtprenatalfecpp" id="txtprenatalfecpp" class="form-control form-control-sm">
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Actualizar datos</button>
        </div>
      </div>
    </div>
  </div>
</form>
