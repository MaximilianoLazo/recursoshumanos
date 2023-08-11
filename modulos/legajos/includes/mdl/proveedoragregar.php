<form id="frm-relojeditar" action="?c=empleado&a=GuardarProveedor" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataAddProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <input type="hidden" class="form-control" id="hddempid" name="hddempid">
              <input type="hidden" class="form-control" id="hddempnrodocto" name="hddempnrodocto">
              <input type="hidden" class="form-control" id="hddcontratoproid" name="hddcontratoproid">
              <!--
              <input type="hidden" class="form-control" id="Imputacion" name="Imputacion">
              <input type="hidden" class="form-control" id="Secretaria" name="Secretaria">
              -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtprofecinicioadd" class="control-label">Fecha de Inicio:</label>
              <input type="date" class="form-control form-control-sm" id="txtprofecinicioadd" name="txtprofecinicioadd">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtprofecfinaladd" class="control-label">Fecha de Finalización:</label>
              <input type="date" class="form-control form-control-sm" id="txtprofecfinaladd" name="txtprofecfinaladd">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboprosecretariaad" class="control-label">Secretaria:</label>
              <select name="cboprosecretariaad" id="cboprosecretariaad" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->Secretarias() as $row): ?>
                      <option value="<?php echo $row->secretaria_id; ?>"><?php echo $row->secretaria_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboprolugardetrabajoadd" class="control-label">Lugar de Trabajo:</label>
              <select name="cboprolugardetrabajoadd" id="cboprolugardetrabajoadd" class="custom-select form-control" required>
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
              <label for="txtprotareaadd" class="control-label">Tarea:</label>
              <input type="text" class="form-control form-control-sm" id="txtprotareaadd" name="txtprotareaadd">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtprosueldobasicoadd" class="control-label">Sueldo Basico $:</label>
              <input type="number" class="form-control form-control-sm" id="txtprosueldobasicoadd" name="txtprosueldobasicoadd" step="0.01">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cbomodelocontrato" class="control-label">Modelo de contrato:</label>
              <select name="cbomodelocontrato" id="cbomodelocontrato" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                        <?php foreach($this->model->ListarModeloContrato() as $row): ?>
                              <option value="<?php echo $row->contrato_modelo_id; ?>"><?php echo $row->contrato_modelonombre; ?></option>
                        <?php endforeach; ?>
                  
              </select>
            </div>
          </div>
        </div>
      </div>
     <!-- -->
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar datos</button>
      </div>
    </div>
  </div>
</div>
</form>
