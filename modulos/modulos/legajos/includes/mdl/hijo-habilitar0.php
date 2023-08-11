<form id="#" action="?c=empleado&a=HijoHabilitar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="dataEnableHijo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
          <input type="hidden" id="hddempndoce" name="hddempndoce">
          <input type="hidden" id="hddbenndoce" name="hddbenndoce">
  	      <p class="lead text-muted text-center" style="display: block;margin:10px">Esta accigón acción habilitara la asignacion del hijo Seleccionado. Deseas continuar?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-lg btn-success">Habilitar</button>
        </div>
      </div>
    </div>
  </div>
</form>
