<form id="frm-relojeditar" action="?c=empleado&a=GuardarContrato" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataAddContrato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <!--<input type="hidden" class="form-control" id="id" name="id">-->
              <input type="hidden" class="form-control" id="EmpId" name="EmpId">
              <input type="hidden" class="form-control" id="ContratoId" name="ContratoId">
              <input type="hidden" class="form-control" id="EmpNroDocto" name="EmpNroDocto">
              <input type="hidden" class="form-control" id="Imputacion" name="Imputacion">
              <input type="hidden" class="form-control" id="Secretaria" name="Secretaria">
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-xs-6 col-sm-6">
          <div class="form-group">
              <label for="CboEmpTipoLegajoAdd" class="control-label">Tipo de legajo:</label>
              <select name="CboEmpTipoLegajoAdd" id="CboEmpTipoLegajoAdd" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->ListarTiposLegajosA() as $row): ?>
                      <option value="<?php echo $row->legtipo_id; ?>"><?php echo $row->legtipo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
            
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="TxtEmpFechaInicioAdd" class="control-label">Fecha de Inicio:</label>
              <input type="date" class="form-control form-control-sm" id="TxtEmpFechaInicioAdd" name="TxtEmpFechaInicioAdd">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="TxtEmpFechaFinalizacionAdd" class="control-label">Fecha de Finalización:</label>
              <input type="date" class="form-control form-control-sm" id="TxtEmpFechaFinalizacionAdd" name="TxtEmpFechaFinalizacionAdd">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="CboEmpSecretariaAdd" class="control-label">Secretaria:</label>
              <select name="CboEmpSecretariaAdd" id="CboEmpSecretariaAdd" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->Secretarias() as $row): ?>
                      <option value="<?php echo $row->secretaria_id; ?>"><?php echo $row->secretaria_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="CboEmpImputacionAdd" class="control-label">Imputacion:</label>
              <select name="CboEmpImputacionAdd" id="CboEmpImputacionAdd" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
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
              <label for="CboEmpImpDependenciaAdd" class="control-label">Dependencia:</label>
              <select name="CboEImpDependenciaadAdd" id="CboEmpImpDependenciaAdd" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="CboEmpLugarDeTrabajoAdd" class="control-label">Lugar de Trabajo:</label>
              <select name="CboEmpLugarDeTrabajoAdd" id="CboEmpLugarDeTrabajoAdd" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
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
              <label for="TxtEmpTareaAdd" class="control-label">Tarea:</label>
              <input type="text" class="form-control form-control-sm" id="TxtEmpTareaAdd" name="TxtEmpTareaAdd">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="TxtEmpSuedoBasicoAdd" class="control-label">Sueldo Basico $:</label>
              <input type="number" class="form-control form-control-sm" id="TxtEmpSuedoBasicoAdd" name="TxtEmpSuedoBasicoAdd" step="0.01">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="CboModeloContrato" class="control-label">Modelo de contrato:</label>
              <select name="CboModeloContrato" id="CboModeloContrato" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->ListarModeloContrato() as $row): ?>
                      <option value="<?php echo $row->contrato_modelo_id; ?>"><?php echo $row->contrato_modelonombre; ?></option>
                  <?php endforeach; ?>
              </select>
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
