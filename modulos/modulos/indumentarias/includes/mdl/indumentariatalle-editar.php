<form id="#" action="?c=indumentaria&a=IndumentariaTalleGuardar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="IndumentariaTalleEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="hddindtalleide" name="hddindtalleide">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="cboindumentarianombrete" class="control-label">Indumentaria:</label>
                <select name="cboindumentarianombrete" id="cboindumentarianombrete" class="custom-select form-control" required>
                  <option value="">--Seleccione--</option>
                    <?php foreach($this->model->IndumentariaListar() as $row): ?>
                        <option value="<?php echo $row->indumentaria_id; ?>"><?php echo $row->indumentaria_nombre; ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text" id="smlindumentaria" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtindumentariatallenombree" class="control-label">Talle: </label>
                <input type="text" name="txtindumentariatallenombree" id="txtindumentariatallenombree" class="form-control form-control-sm" placeholder="" required/>
                <small class="form-text" id="smlcantidad" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnindcarroadd" class="btn btn-primary">AGREGAR</button>
        </div>
      </div>
    </div>
  </div>
</form>
