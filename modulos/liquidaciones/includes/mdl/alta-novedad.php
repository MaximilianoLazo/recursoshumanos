<form id="#" action="?c=liquidacion&a=AltaNovedad" method="post" enctype="multipart/form-data">
<div class="modal fade" id="AltaNovedad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body">
        <input type="hidden" class="form-control" id="hddjub" name="hddjub">
        <input type="hidden" class="form-control" id="hddper" name="hddper">

        <div class="row">

	        <div class="col-md-12">
            <div class="form-group">
              <label for="cbonovedadtipo" class="control-label">Seleccione Tipo de Novedad:</label>
              <select name="cbonovedadtipo" style="font-size: 12px;" id="cbonovedadtipo" class="custom-select form-control" required>
                <option value="">-- SELECCIONE --</option>
                <?php foreach($this->model->ListarNovedadesTodo() as $row): ?>
                <option value="<?php echo $row->liqcod_jub_id; ?>"><?php echo $row->liqcod_nombre; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row">

      <div class="col-md-6">
        <div class="form-group">
          <label for="txtimporte">Immporte :</label>
          <input type="text" style="font-size: 12px;" name="txtimportenov" id="txtimportenov" class="form-control" required>
        </div>
      </div>

    </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
</form>
