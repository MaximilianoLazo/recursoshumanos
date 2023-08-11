<form id="" action="?c=usuario&a=UsuarioHabilitar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="UsuarioHab" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="hddusuarioidhab" name="hddusuarioidhab">

          <p class="lead text-muted text-center" style="display: block;margin:10px">Esta acción acción habilitara el usuario Seleccionado. Deseas continuar?</p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Habilitar</button>
        </div>
      </div>
    </div>
  </div>
</form>