<form id="" action="?c=usuario&a=UsuarioBaja" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="UsuarioBaja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="hddusuarioidbaja" name="hddusuarioidbaja">

          <p class="lead text-muted" style="display: block;margin:0px">Esta acción dara de baja el registro. Deseas continuar?</p>
          <br>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtusuariobobs" class="control-label">Observaciones:</label>
                <textarea style="width:100%;height:80px;border: 1px solid #000000;" class="form-control" name="txtusuariobobs" id="txtusuariobobs" required></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Dar de baja</button>
        </div>
      </div>
    </div>
  </div>
</form>