<form id="#" action="?c=empleado&a=ConyugeDomicilioGuardar" method="post" enctype="multipart/form-data">
<div class="modal fade bd-example-modal-lg" id="ConyugeEditarDomicilio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="hddempide" name="hddempide">
        <input type="hidden" class="form-control" id="hddempnrodoctoe" name="hddempnrodoctoe">
        <input type="hidden" class="form-control" id="hddcyeide" name="hddcyeide">
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtcyedireccione" class="control-label">Dirección:</label>
              <input type="text" name="txtcyedireccione" id="txtcyedireccione" class="form-control form-control-sm" placeholder="Ej: San Antonio Norte" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtcyedirecnroe" class="control-label">Numero: </label>
              <input type="text" name="txtcyedirecnroe" id="txtcyedirecnroe" class="form-control form-control-sm" placeholder="Ej: 203" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtcyedirecpisoe" class="control-label">Piso:</label>
              <input type="text" name="txtcyedirecpisoe" id="txtcyedirecpisoe" class="form-control form-control-sm" placeholder="Ej: PB" >
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="txtcyecpostale" class="control-label">Codigo Postal: </label>
              <input type="text" name="txtcyecpostale" id="txtcyecpostale" class="form-control form-control-sm" placeholder="Ej: 2840" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="cbocyepaise" class="control-label">Pais:</label>
              <select name="cbocyepaise" id="cbocyepaise" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->Paises() as $row): ?>
                      <option value="<?php echo $row->pais_id; ?>"><?php echo $row->pais_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="cbocyeprovinciae" class="control-label">Provincia: </label>
              <select name="cbocyeprovinciae" id="cbocyeprovinciae" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="cbocyedepartamentoe" class="control-label">Departamento:</label>
              <select name="cbocyedepartamentoe" id="cbocyedepartamentoe" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="cbocyelocalidade" class="control-label">Localidad: </label>
              <select name="cbocyelocalidade" id="cbocyelocalidade" class="custom-select form-control" required>
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
