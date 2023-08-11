<form id="" action="?c=empleado&a=ProveedorContratoActualizarI" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateProveedorI" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="hddproid" name="hddproid">
        <input type="hidden" class="form-control" id="hddpronrodocto" name="hddpronrodocto">
        <input type="hidden" class="form-control" id="hddprocontratoid" name="hddprocontratoid">
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="proveedordatosanteriores">
                <label class="custom-control-label" for="proveedordatosanteriores">Obtener Datos Anteriores</label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtprofechainicioacti" class="control-label">Fecha de Inicio:</label>
              <input type="date" class="form-control form-control-sm" id="txtprofechainicioacti" name="txtprofechainicioacti">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtprofechafinalacti" class="control-label">Fecha de Finalización:</label>
              <input type="date" class="form-control form-control-sm" id="txtprofechafinalacti" name="txtprofechafinalacti">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboprosecretariaacti" class="control-label">Secretaria:</label>
              <select name="cboprosecretariaacti" id="cboprosecretariaacti" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->Secretarias() as $row): ?>
                      <option value="<?php echo $row->secretaria_id; ?>"><?php echo $row->secretaria_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboproltrabajoacti" class="control-label">Lugar de Trabajo:</label>
              <select name="cboproltrabajoacti" id="cboproltrabajoacti" class="custom-select form-control" required>
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
              <label for="txtprotareaacti" class="control-label">Tarea:</label>
              <input type="text" class="form-control form-control-sm" id="txtprotareaacti" name="txtprotareaacti">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtprosueldobasicoacti" class="control-label">Sueldo Basico:</label>
              <input type="number" class="form-control form-control-sm" id="txtprosueldobasicoacti" name="txtprosueldobasicoacti" step="0.01">
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
