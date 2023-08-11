<form id="#" action="?c=indumentaria&a=IndumentariaTalleEliminar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="IndumentariaTalleBaja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="hddindumentariatalleidd" name="hddindumentariatalleidd">
          <p class="lead text-muted text-center" style="display: block;margin:10px">Esta acción eliminará de forma permanente el registro. Deseas continuar?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnempleadoguardar" class="btn btn-danger">DAR DE BAJA</button>
        </div>
      </div>
    </div>
  </div>
</form>
