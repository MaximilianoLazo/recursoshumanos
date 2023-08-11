<form id="" action="?c=empleado&a=GuardarContratoAct" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateContrato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <input type="hidden" class="form-control" id="EmpId" name="EmpId">
              <input type="hidden" class="form-control" id="EmpNroDocto" name="EmpNroDocto">
              <input type="hidden" class="form-control" id="ContratoId" name="ContratoId">
              <input type="hidden" class="form-control" id="Imputacion" name="Imputacion">
              <input type="hidden" class="form-control" id="Secretaria" name="Secretaria">
              <input type="hidden" class="form-control" id="NrosDocto" name="NrosDocto">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboemptipolegajoact" class="control-label">Tipo de Legajo:</label>
              <select name="cboemptipolegajoact" id="cboemptipolegajoact" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->TiposLegajos() as $row): ?>
                      <option value="<?php echo $row->legtipo_id; ?>"><?php echo $row->legtipo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">

          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtempfechainicioact" class="control-label">Fecha de Inicio:</label>
              <input type="date" class="form-control form-control-sm" id="txtempfechainicioact" name="txtempfechainicioact">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtempfechafinalizacionact" class="control-label">Fecha de Finalización:</label>
              <input type="date" class="form-control form-control-sm" id="txtempfechafinalizacionact" name="txtempfechafinalizacionact">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboempsecretariaact" class="control-label">Secretaria:</label>
              <select name="cboempsecretariaact" id="cboempsecretariaact" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->Secretarias() as $row): ?>
                      <option value="<?php echo $row->secretaria_id; ?>"><?php echo $row->secretaria_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboempimputacionact" class="control-label">Imputacion:</label>
              <select name="cboempimputacionact" id="cboempimputacionact" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->ListarImputaciones() as $row): ?>
                      <option value="<?php echo $row->imputacion_id; ?>"><?php echo $row->imputacion_codigow."C ".$row->imputacion_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboempactividadact" class="control-label">Dependencia:</label>
              <select name="cboempactividadact" id="cboempactividadact" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboemplugardetrabajoact" class="control-label">Lugar de Trabajo:</label>
              <select name="cboemplugardetrabajoact" id="cboemplugardetrabajoact" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->LugaresTrabajo() as $row): ?>
                      <option value="<?php echo $row->trabajo_id; ?>"><?php echo $row->trabajo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>

            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">

            <div class="form-group">
              <label for="txtemptareaact" class="control-label">Tarea:</label>
              <input type="text" class="form-control form-control-sm" id="txtemptareaact" name="txtemptareaact">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtempsueldobasicoact" class="control-label">Sueldo Basico $:</label>
              <input type="number" class="form-control form-control-sm" id="txtempsueldobasicoact" name="txtempsueldobasicoact" step="0.01">
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
