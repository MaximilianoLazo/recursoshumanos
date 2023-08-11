<?php
  date_default_timezone_set("America/Buenos_Aires");
  $date = new DateTime(date("Y-m-d"));
  $fecha_actual = $date->format('Y-m-d');
?>
<form id="" action="?c=empleado&a=BajaEmpleado" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="EmpleadoBaja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="hddempide" name="hddempide">
          <input type="text" class="form-control" id="hddempnrodoctoe" name="hddempnrodoctoe">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtempfecbajae" class="control-label">Fecha de Baja: </label>
                <input type="date" name="txtempfecbajae" id="txtempfecbajae" value="<?php echo $fecha_actual; ?>" class="form-control form-control-sm" required />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtempbajaobse" class="control-label">Observaciones:</label>
                <textarea style="width:100%;height:80px;border: 1px solid #000000;" class="form-control" name="txtempbajaobse" id="txtempbajaobse" ></textarea>
              </div>
            </div>
          </div>
          <!--
          <div id="tabladato">
          </div>
          -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnempleadoguardar" class="btn btn-primary">GUARDAR DATOS</button>
        </div>
      </div>
    </div>
  </div>
</form>
