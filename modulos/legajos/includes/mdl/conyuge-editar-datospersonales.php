<form id="" action="?c=empleado&a=ConyugeGuardar" method="post" enctype="multipart/form-data">
<div class="modal fade" id="ConyugeEditarDatosPersonales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="hddempide" name="hddempide">
        <input type="hidden" class="form-control" id="hddempnrodoctoe" name="hddempnrodoctoe">
        <input type="hidden" class="form-control" id="hddcyeide" name="hddcyeide">
        <!--<input type="hidden" class="form-control" id="hddempmovimientoe" name="hddempmovimientoe">-->
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtcyenrodoctoe" class="control-label">DNI:</label>
              <input type="text" name="txtcyenrodoctoe" id="txtcyenrodoctoe" class="form-control form-control-sm" placeholder="Ej: 22330150">
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtcyenrocuile" class="control-label">CUIL: </label>
              <input type="text" name="txtcyenrocuile" id="txtcyenrocuile" class="txtempnrocuile form-control form-control-sm" placeholder="Ej: 20-22330150-4" required />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="txtcyeapellidoe" class="control-label">Apellido: </label>
              <input type="text" name="txtcyeapellidoe" id="txtcyeapellidoe" class="form-control form-control-sm" placeholder="Ej: Gonzalez" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="txtcyenombrese" class="control-label">Nombres:</label>
              <input type="text" name="txtcyenombrese" id="txtcyenombrese" class="form-control form-control-sm" placeholder="Ej: Marcela" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="cbocyesexoe" class="control-label">Sexo:</label>
              <select name="cbocyesexoe" id="cbocyesexoe" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->Sexos() as $row): ?>
                      <option value="<?php echo $row->sexo_id; ?>"><?php echo $row->sexo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtcyefecnactoe" class="control-label">Fecha de Nacimiento:</label>
              <input type="date" name="txtcyefecnactoe" id="txtcyefecnactoe" class="form-control form-control-sm" placeholder="Ej: 02/10/1981" required>
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
