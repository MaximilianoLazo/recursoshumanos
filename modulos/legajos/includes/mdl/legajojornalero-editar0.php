<form id="#" action="?c=empleado&a=GuardarCJornalero" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateJornalero" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="hddempidjor" name="hddempidjor">
        <input type="hidden" class="form-control" id="hddempnrodoctojor" name="hddempnrodoctojor">
        <input type="hidden" class="form-control" id="hddidjor" name="hddidjor">
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cbotipolegajojor" class="control-label">Tipo de Legajo:</label>
              <select name="cbotipolegajojor" id="cbotipolegajojor" class="custom-select form-control" disabled>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->TiposLegajos() as $row): ?>
                      <option value="<?php echo $row->legtipo_id; ?>"><?php echo $row->legtipo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cbosecretariajornalero" class="control-label">Secretaria:</label>
              <select name="cbosecretariajornalero" id="cbosecretariajornalero" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->Secretarias() as $row): ?>
                      <option value="<?php echo $row->secretaria_id; ?>"><?php echo $row->secretaria_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboimputacionjor" class="control-label">Imputacion:</label>
              <select name="cboimputacionjor" id="cboimputacionjor" class="custom-select form-control" disabled>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->ListarImputaciones() as $row): ?>
                      <option value="<?php echo $row->imputacion_id; ?>"><?php echo $row->imputacion_codigow." ".$row->imputacion_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cbolugartrabajojor" class="control-label">Lugar de Trabajo:</label>
              <select name="cbolugartrabajojor" id="cbolugartrabajojor" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->LugaresTrabajo() as $row): ?>
                      <option value="<?php echo $row->trabajo_id; ?>"><?php echo $row->trabajo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txttareajor" class="control-label">Tarea:</label>
              <input type="text" class="form-control form-control-sm" id="txttareajor" name="txttareajor">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtsueldobasicojor" class="control-label">Sueldo Basico $:</label>
              <input type="number" class="form-control form-control-sm" id="txtsueldobasicojor" name="txtsueldobasicojor" step="0.01" disabled>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtfecantiguedadjor" class="control-label">Fecha de Antigüedad:</label>
              <input type="date" class="form-control form-control-sm" id="txtfecantiguedadjor" name="txtfecantiguedadjor">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar datos</button>
      </div>
    </div>
  </div>
</div>
</form>
