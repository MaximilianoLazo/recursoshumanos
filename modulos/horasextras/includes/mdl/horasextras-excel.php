<form id="#" action="?c=horasextras&a=GuardarHorasExtras" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataViewHorasExtrasExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="hddhsexltrabajoid" name="hddhsexltrabajoid">
        <input type="hidden" class="form-control" id="hddhsexltrabajonombre" name="hddhsexltrabajonombre">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <div align="right">
                <!--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dataViewHorasExtrasPDF" data-titulo="<?php echo "Listado de Horas Extras Completo - PDF"; ?>">DESCARGAR PDF</button>-->
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="cbohsextrasperiodo" class="control-label">Periodo:</label>
              <select name="cbohsextrasperiodo" id="cbohsextrasperiodo" class="custom-select form-control" required disabled>
                <?php
                  $row = $this->model->PeriodoUCerrado();
                  $periodofeci = date("d/m/Y", strtotime($row->periodo_hsext_jor_i));
                  $periodofecf = date("d/m/Y", strtotime($row->periodo_hsext_jor_f));
                ?>
                    <option value="<?php echo $row->periodo_id; ?>"><?php echo $row->periodo_nombre." ".$periodofeci." a ".$periodofecf; ?></option>

              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="hsextrasdni" class="control-label">Lugar de Trabajo:</label>
              <select name="CboSecretarias" id="CboSecretarias" class="custom-select form-control" required>
                <option value="">Todos --></option>
                  <?php foreach($this->model->ListarLugaresDeTrabajo() as $row): ?>
                          <option value="<?php echo $row->trabajo_id; ?>"><?php echo $row->trabajo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="hsextrasempleado" class="control-label">Tipo de Legajo:</label>
              <select name="CboSecretarias" id="CboSecretarias" class="custom-select form-control" required>
                <option value="">Todos --></option>
                  <?php foreach($this->model->ListarTiposDeLegajos() as $row): ?>
                          <option value="<?php echo $row->legtipo_id; ?>"><?php echo $row->legtipo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#dataViewHorasExtrasPDF" data-titulo="<?php echo "Listado de Horas Extras Completo - PDF"; ?>">DESCARGAR EXCEL</button>
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
