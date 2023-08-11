<?php
  date_default_timezone_set("America/Buenos_Aires");
  $date = new DateTime(date("Y-m-d"));
  $fecha_actual = $date->format('Y-m-d');
?>
<form id="" action="?c=liquidacion&a=LiquidacionDescuentos" method="post" enctype="multipart/form-data">
<div class="modal fade" id="LiquidacionAltaDescuentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="hddndoce" name="hddndoce">
        <input type="hidden" class="form-control" id="hddempndoclde" name="hddempndoclde">
        <input type="hidden" class="form-control" id="hddperiodoe" name="hddperiodoe">
        <input type="hidden" class="form-control" id="hddtitulare" name="hddtitulare">
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="cboliqcoddescuentoe" class="control-label">Codigo de Descuento: </label>
              <select name="cboliqcoddescuentoe" id="cboliqcoddescuentoe" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->ObtenerLiquidacionCodxTipo(4) as $row): ?>
                      <option value="<?php echo $row->liqcod_id; ?>"><?php echo $row->liqcod_id." ".$row->liqcod_descripcion; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="txtliqimportee" class="control-label">Importe: </label>
              <input type="number" name="txtliqimportee" id="txtliqimportee" class="txtempnrocuile form-control form-control-sm" placeholder="Ej: 1000,00" required />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="txtliqobse" class="control-label">Observaciones:</label>
              <textarea style="width:100%;height:80px;border: 1px solid #000000;" class="form-control" name="txtliqobse" id="txtliqobse" required></textarea>
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
