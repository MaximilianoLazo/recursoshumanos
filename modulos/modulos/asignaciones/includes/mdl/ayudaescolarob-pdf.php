<form id="#" action="#" method="post" enctype="multipart/form-data">
<div class="modal fade" id="AyudaEscolarOBPPDF" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel"></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <!--
        <input type="hidden" class="form-control" id="hddhsexltrabajoid" name="hddhsexltrabajoid">
        <input type="hidden" class="form-control" id="hddhsexltrabajonombre" name="hddhsexltrabajonombre">
        -->
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cbotlistadoasignacionesfam" class="control-label">Tipo de Listado:</label>
              <select name="cbotlistadoasignacionesfam" id="cbotlistadoasignacionesfam" class="custom-select form-control" required>
                <option value="R">Listado Resumido</option>
                <option value="C">Listado Completo</option>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cbotipoasignacionesfam" class="control-label">Tipos de Asignaciones:</label>
              <select name="cbotipoasignacionesfam" id="cbotipoasignacionesfam" class="custom-select form-control" required>
                <option value="T">Todas --></option>
                  <?php foreach($this->model->ObtenerAsignacionesOB() as $row): ?>
                          <option value="<?php echo $row->asigtipo_id; ?>"><?php echo $row->asigtipo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cbotipolegajoasignacionesfam" class="control-label">Tipo de Legajo:</label>
              <select name="cbotipolegajoasignacionesfam" id="cbotipolegajoasignacionesfam" class="custom-select form-control" required>
                <option value="T">Todos --></option>
                  <?php foreach($this->model->TiposLegajos() as $row): ?>
                          <option value="<?php echo $row->legtipo_id; ?>"><?php echo $row->legtipo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="cboordenasignacionesfam" class="control-label">Ordenar Por:</label>
              <select name="cboordenasignacionesfam" id="cboordenasignacionesfam" class="custom-select form-control" required>
                <option value="1">Empleado / Apellido y Nombres</option>
                <option value="1">Empleado / DNI</option>
                <option value="2">Beneficiario / Apellido y Nombres</option>
                <option value="2">Beneficiario / DNI</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="inovedadesasignacionesfam" checked>
                <label class="custom-control-label" for="inovedadesasignacionesfam"> Incluir Novedades ?</label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="btnayudaescolarobimplistado">DESCARGAR PDF</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</form>

<script>

</script>
<script type="text/javascript">

</script>