<form id="frm-estudiodeshabilitar" action="?c=empleado&a=DeshabilitarH" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateFichadaDia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Estas seguro?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hijoid" name="hijoid">
        <input type="hidden" id="empid" name="empid">
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboentrada1" class="control-label">Entrada 1: </label>
              <select name="cboentrada1" id="cboentrada1" class="custom-select form-control" required>
                <option value="">Fichada no encontradada</option>
                  <?php
                    foreach($this->model->FichadasDescartadas() as $row):
                      $fechamuestra = (iconv('ISO-8859-2', 'UTF-8', strftime("%d/%m/%Y %H:%M", strtotime("$row->marcacion_datetime"))));
                  ?>
                      <option value="<?php echo $row->marcacion_id; ?>"><?php echo $fechamuestra; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="hijonombres" class="control-label">Salida 1:</label>
              <input type="text" name="hijonombres" id="hijonombres" class="form-control form-control-sm" placeholder="Ej: Jose Luis" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="hijoapellido" class="control-label">Entrada 2: </label>
              <input type="text" name="hijoapellido" id="hijoapellido" class="form-control form-control-sm" placeholder="Ej: Gonzalez" required>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="hijonombres" class="control-label">Salida 2:</label>
              <input type="text" name="hijonombres" id="hijonombres" class="form-control form-control-sm" placeholder="Ej: Jose Luis" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="hijoapellido" class="control-label">Entrada 3: </label>
              <input type="text" name="hijoapellido" id="hijoapellido" class="form-control form-control-sm" placeholder="Ej: Gonzalez" required>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="hijonombres" class="control-label">Salida 3:</label>
              <input type="text" name="hijonombres" id="hijonombres" class="form-control form-control-sm" placeholder="Ej: Jose Luis" required>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-lg btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>
</form>
<script>
/*
    $(document).ready(function(){
        $("#frm-relojdeshabilitar").submit(function(){
            return $(this).validate();
        });
    })
*/
</script>
