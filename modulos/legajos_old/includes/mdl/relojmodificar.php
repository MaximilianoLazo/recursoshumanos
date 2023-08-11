<form id="frm-relojeditar" action="?c=empleado&a=GuardarReE" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateReloj" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
			<div id="datos_ajax"></div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input type="hidden" class="form-control" id="id" name="id">
              <input type="hidden" class="form-control" id="empid" name="empid">
              <input type="hidden" class="form-control" id="empnrodocto" name="empnrodocto">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-5 col-sm-5">
            <div class="form-group">
              <label for="relojid" class="control-label">Reloj:</label>
              <select name="relojid" id="relojid" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->Relojes() as $row): ?>
                      <option value="<?php echo $row->reloj_id; ?>"><?php echo $row->reloj_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-5 col-sm-4">
            <div class="form-group">
              <label for="accessid" class="control-label">ID:</label>
              <input type="number" class="form-control form-control-sm" id="accessid" name="accessid">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="semanalup" class="control-label">Semanal?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="semanalup" name="semanalup" value="1">
                <label class="custom-control-label" for="semanalup"></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Actualizar datos</button>
      </div>
    </div>
  </div>
</div>
</form>
