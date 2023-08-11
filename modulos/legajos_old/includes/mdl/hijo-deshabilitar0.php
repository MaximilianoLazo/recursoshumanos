<form id="#" action="?c=empleado&a=HijoDeshabilitar" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataDisableHijo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hijoid" name="hijoid">
        <input type="hidden" id="empid" name="empid">
        <input type="hidden" id="hddempndoce" name="hddempndoce">
        <input type="hidden" id="hddbenndoce" name="hddbenndoce">
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
              <label for="txtasignaciondes" class="control-label">Observacones:</label>
              <textarea class="form-control" rows="1" cols="2" style="color:#FF0000" name="txtasignaciondes" id="txtasignaciondes"></textarea>
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
<script>
/*
    $(document).ready(function(){
        $("#frm-relojdeshabilitar").submit(function(){
            return $(this).validate();
        });
    })
*/
</script>
