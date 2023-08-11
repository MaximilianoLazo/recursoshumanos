<form id="#" action="?c=empleado&a=PreNatalDeshabilitar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="dataDisablePreNatal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <input type="hidden" id="prenataldesid" name="prenataldesid">
          <input type="hidden" id="empid" name="empid">
          <input type="hidden" id="hddempndoc" name="hddempndoc">
          <input type="hidden" id="hddbenndoc" name="hddbenndoc">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
  	             <p class="lead text-muted text-left">Esta acción Deshabilitara la asignacion del hijo seleccionado. Deseas continuar?</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtprenataldeshabilitar" class="control-label">Observacones:</label>
                <textarea class="form-control" rows="1" cols="2" style="color:#FF0000" name="txtprenataldeshabilitar" id="txtprenataldeshabilitar"></textarea>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-lg btn-danger">Deshabilitar</button>
        </div>
      </div>
    </div>
  </div>
</form>
