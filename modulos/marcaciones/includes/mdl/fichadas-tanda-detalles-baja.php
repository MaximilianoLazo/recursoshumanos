<form id="#" action="?c=marcacion&a=FichadasTandaDetallesBaja" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="FichadasTandaDetallesBaja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="hddmtandaide" name="hddmtandaide">
          <input type="hidden" class="form-control" id="hddmtandadetalleide" name="hddmtandadetalleide">
          <p class="lead text-muted text-center" style="display: block;margin:10px">
            Esta acción quitara el empleado de esta lista. Deseas continuar?
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnempleadoguardar" class="btn btn-danger">Quitar</button>
        </div>
      </div>
    </div>
  </div>
</form>
