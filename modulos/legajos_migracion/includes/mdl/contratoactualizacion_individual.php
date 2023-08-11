<form id="" action="?c=empleado&a=GuardarContratoActualizarI" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateContratoI" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="ContratoIdActInd" name="ContratoIdActInd">
        <input type="hidden" class="form-control" id="EmpIdActInd" name="EmpIdActInd">
        <input type="hidden" class="form-control" id="EmpNroDoctoActInd" name="EmpNroDoctoActInd">
        <!--
        <input type="hidden" class="form-control" id="Imputacion" name="Imputacion">
        <input type="hidden" class="form-control" id="Secretaria" name="Secretaria">
        -->
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="datosant">
                <label class="custom-control-label" for="datosant">Obtener Datos Anteriores</label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboemptipolegajoacti" class="control-label">Tipo de Legajo:</label>
              <select name="cboemptipolegajoacti" id="cboemptipolegajoacti" class="custom-select form-control" required>
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
              <label for="txtempfechainicioacti" class="control-label">Fecha de Inicio:</label>
              <input type="date" class="form-control form-control-sm" id="txtempfechainicioacti" name="txtempfechainicioacti">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtempfechafinalizacionacti" class="control-label">Fecha de Finalización:</label>
              <input type="date" class="form-control form-control-sm" id="txtempfechafinalizacionacti" name="txtempfechafinalizacionacti">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboempsecretariaacti" class="control-label">Secretaria:</label>
              <select name="cboempsecretariaacti" id="cboempsecretariaacti" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->Secretarias() as $row): ?>
                      <option value="<?php echo $row->secretaria_id; ?>"><?php echo $row->secretaria_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboempimputacionacti" class="control-label">Imputacion:</label>
              <select name="cboempimputacionacti" id="cboempimputacionacti" class="custom-select form-control" required>
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
              <label for="cboempdependenciaacti" class="control-label">Dependencia:</label>
              <select name="cboempdependenciaacti" id="cboempdependenciaacti" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtemptareaacti" class="control-label">Tarea:</label>
              <input type="text" class="form-control form-control-sm" id="txtemptareaacti" name="txtemptareaacti">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboemplugardetrabajoacti" class="control-label">Lugar de Trabajo:</label>
              <select name="cboemplugardetrabajoacti" id="cboemplugardetrabajoacti" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->LugaresTrabajo() as $row): ?>
                      <option value="<?php echo $row->trabajo_id; ?>"><?php echo $row->trabajo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtempsueldobasicoacti" class="control-label">Sueldo Basico:</label>
              <input type="number" class="form-control form-control-sm" id="txtempsueldobasicoacti" name="txtempsueldobasicoacti" step="0.01">
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
