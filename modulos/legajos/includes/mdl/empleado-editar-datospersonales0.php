<form id="" action="?c=empleado&a=GuardarEmpleado" method="post" enctype="multipart/form-data">
<div class="modal fade bd-example-modal-lg" id="EmpleadoEditarDatosPersonales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="hddempide" name="hddempide">
        <input type="hidden" class="form-control" id="hddempnrodocto" name="hddempnrodocto">
        <input type="hidden" class="form-control" id="hddempmovimientoe" name="hddempmovimientoe">
        <div class="row">
          <div class="col-xs-12 col-sm-4">
            <div class="form-group">
              <label for="txtnrodoctoe" class="control-label">DNI:</label>
              <input type="text" name="txtnrodoctoe" id="txtnrodoctoe" class="form-control form-control-sm" placeholder="Ej: 22330150" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group">
              <label for="txtempnrocuile" class="control-label">CUIL: </label>
              <input type="text" name="txtempnrocuile" id="txtempnrocuile" class="txtempnrocuile form-control form-control-sm" placeholder="Ej: 20-22330150-4" required />
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group">
              <label for="txtempnrolegajoe" class="control-label">Nro de Legajo:</label>
              <input type="text" name="txtempnrolegajoe" id="txtempnrolegajoe" class="form-control form-control-sm" placeholder="Ej: 365899" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="txtempapellidoe" class="control-label">Apellido: </label>
              <input type="text" name="txtempapellidoe" id="txtempapellidoe" class="form-control form-control-sm" placeholder="Ej: Gonzalez" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="txtempnombrese" class="control-label">Nombres:</label>
              <input type="text" name="txtempnombrese" id="txtempnombrese" class="form-control form-control-sm" placeholder="Ej: Jose Luis" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="cboempsexoe" class="control-label">Sexo:</label>
              <select name="cboempsexoe" id="cboempsexoe" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->Sexos() as $row): ?>
                      <option value="<?php echo $row->sexo_id; ?>"><?php echo $row->sexo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="cboempestadocivile" class="control-label">Estado Civil:</label>
              <select name="cboempestadocivile" id="cboempestadocivile" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->EstadosC() as $row): ?>
                      <option value="<?php echo $row->estcivil_id; ?>"><?php echo $row->estcivil_nombre; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtempfecnace" class="control-label">Fecha de Nacimiento:</label>
              <input type="date" name="txtempfecnace" id="txtempfecnace" class="form-control form-control-sm" placeholder="Ej: 02/10/1981" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtempfecinge" class="control-label">Fecha de Ingreso:</label>
              <input type="date" name="txtempfecinge" id="txtempfecinge" class="form-control form-control-sm" placeholder="Ej: 02/10/1981" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <div class="alert-empactivo alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
                <strong>ATENCIÓN!</strong> El empleado se encuentra activo.
                <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                -->
              </div>
              <div class="alert-empinactivo alert alert-warning alert-dismissible fade show" role="alert" style="display:none;">
                <strong>ATENCIÓN!</strong> El empleado se encuentra inactivo, quedara activo al Guardar los datos.
                <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="btnempleadoguardar" class="btn btn-primary">GUARDAR DATOS</button>
      </div>
    </div>
  </div>
</div>
</form>
