<form id="frm-estudiodeshabilitar" action="?c=empleado&a=HijoEliminar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="dataDeleteHijo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Estas seguro?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <input type="hidden" id="hijoid" name="hijoid">
          <input type="hidden" id="empid" name="empid">
          <input type="hidden" id="hddempndoc" name="hddempndoc">
          <input type="hidden" id="hddbenndoc" name="hddbenndoc">
  	      <p class="lead text-muted text-center" style="display: block;margin:10px">Esta acción eliminará de forma permanente el registro. Deseas continuar?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-lg btn-danger">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</form>
