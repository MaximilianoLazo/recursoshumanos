<form id="#" action="?c=legajo&a=GuardarEmpleadoDomicilio" method="post" enctype="multipart/form-data">
<div class="modal fade bd-example-modal-lg" id="EmpleadoEditarDomicilio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="hddempide" name="hddempide">
        <input type="hidden" class="form-control" id="hddempnrodoctoe" name="hddempnrodoctoe">
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtempdireccione" class="control-label">Dirección:</label>
              <input type="text" name="txtempdireccione" id="txtempdireccione" class="form-control form-control-sm" placeholder="Ej: 22330150" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtempdirenroe" class="control-label">Numero: </label>
              <input type="text" name="txtempdirenroe" id="txtempdirenroe" class="form-control form-control-sm" placeholder="Ej: 20-22330150-4" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtempdirecpisoe" class="control-label">Piso:</label>
              <input type="text" name="txtempdirecpisoe" id="txtempdirecpisoe" class="form-control form-control-sm" placeholder="Ej: PB" >
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtempcpostale" class="control-label">Codigo Postal: </label>
              <input type="text" name="txtempcpostale" id="txtempcpostale" class="form-control form-control-sm" placeholder="Ej: 2840" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="cboemppaise" class="control-label">Pais:</label>
              <select name="cboemppaise" id="cboemppaise" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->Paises() as $row): ?>
                      <option value="<?php echo $row->pais_id; ?>"><?php echo $row->pais_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="cboempprovinciae" class="control-label">Provincia: </label>
              <select name="cboempprovinciae" id="cboempprovinciae" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="cboempdepartamentoe" class="control-label">Departamento:</label>
              <select name="cboempdepartamentoe" id="cboempdepartamentoe" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="cboemplocalidade" class="control-label">Localidad: </label>
              <select name="cboemplocalidade" id="cboemplocalidade" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">GUARDAR DATOS</button>
      </div>
    </div>
  </div>
</div>
</form>
<script type="text/javascript">
</script>
