<form id="" action="?c=usuario&a=UsuarioGuardar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="UsuarioEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="hddusuarioid" name="hddusuarioid">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <!--<div class="form-group">-->
              <div class="mb-3">
                <label for="txtusuario" class="control-label">Usuario:</label>
                <input type="text" name="txtusuario" id="txtusuario" class="form-control form-control-sm" placeholder="Ej: vendedor01" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="mb-3">
                <label for="cbousuariotipo" class="control-label">Tipo de Usuario:</label>
                <select name="cbousuariotipo" id="cbousuariotipo" class="custom-select form-control" required>
                  <option value="">--Seleccione--</option>
                  <?php foreach ($this->model->UsuariosTiposListar() as $row) :
                  ?>
                    <option value="<?php echo $row->usuario_tipo_id; ?>"><?php echo $row->usuario_tipo_nombre; ?></option>
                  <?php endforeach;
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" id="" class="btn btn-primary">Guardar Datos</button>
        </div>
      </div>
    </div>
  </div>
</form>