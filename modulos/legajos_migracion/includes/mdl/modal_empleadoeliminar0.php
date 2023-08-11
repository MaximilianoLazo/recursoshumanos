<form id="eliminarDatos">
  <div class="modal fade" id="dataDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <input type="hidden" id="id_pais" name="id_pais">
          <h5 class="modal-title" id="exampleModalLabel">Esta Seguro?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
	        <p class="lead text-muted text-center" style="display: block;margin:10px">Esta acción eliminará de forma permanente el registro. Deseas continuar?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-lg btn-primary">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</form>
