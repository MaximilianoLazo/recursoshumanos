<form id="#" action="?c=empleado&a=GuardarCPPermanente" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdatePPermanente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="hddempidpp" name="hddempidpp">
        <input type="hidden" class="form-control" id="hddempnrodoctopp" name="hddempnrodoctopp">
        <input type="hidden" class="form-control" id="hddppid" name="hddppid">
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cbotipolegajopp" class="control-label">Tipo de Legajo:</label>
              <select name="cbotipolegajopp" id="cbotipolegajopp" class="custom-select form-control" disabled>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->TiposLegajos() as $row): ?>
                      <option value="<?php echo $row->legtipo_id; ?>"><?php echo $row->legtipo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtcategoriapp" class="control-label">Categoria:</label>
              <input type="number" class="form-control form-control-sm" id="txtcategoriapp" name="txtcategoriapp">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cbosecretariapp" class="control-label">Secretaria:</label>
              <select name="cbosecretariapp" id="cbosecretariapp" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->Secretarias() as $row): ?>
                      <option value="<?php echo $row->secretaria_id; ?>"><?php echo $row->secretaria_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboimputacionpp" class="control-label">Imputacion:</label>
              <select name="cboimputacionpp" id="cboimputacionpp" class="custom-select form-control" disabled>
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
              <label for="cbolugartrabajopp" class="control-label">Lugar de Trabajo:</label>
              <select name="cbolugartrabajopp" id="cbolugartrabajopp" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->LugaresTrabajo() as $row): ?>
                      <option value="<?php echo $row->trabajo_id; ?>"><?php echo $row->trabajo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txttareapp" class="control-label">Tarea:</label>
              <input type="text" class="form-control form-control-sm" id="txttareapp" name="txttareapp">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtsueldobasicopp" class="control-label">Sueldo Basico $:</label>
              <input type="number" class="form-control form-control-sm" id="txtsueldobasicopp" name="txtsueldobasicopp" step="0.01" disabled>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtfecantiguedadpp" class="control-label">Fecha de Antigüedad:</label>
              <input type="date" class="form-control form-control-sm" id="txtfecantiguedadpp" name="txtfecantiguedadpp">
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
