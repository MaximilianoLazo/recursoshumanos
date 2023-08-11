<form id="" action="?c=usuario&a=UsuarioClaveResetear" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="UsuarioClaveRes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="hddusuarioidres" name="hddusuarioidres">
          <input type="hidden" id="hddusuariores" name="hddusuariores">
          <p class="lead text-muted text-center" style="display: block;margin:10px">Esta acción acción reseteará la clave del Usuario Seleccionado. Deseas continuar?</p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Resetear</button>
        </div>
      </div>
    </div>
  </div>
</form>
