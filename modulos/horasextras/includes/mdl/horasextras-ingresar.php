<form id="#" action="?c=horasextras&a=GuardarHorasExtras" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateHorasExtras" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
          <div class="col-xs-4 col-sm-4">
            <div class="form-group">
              <label for="hsextrasdni" class="control-label">DNI:</label>
              <input type="text" class="form-control form-control-sm" id="hsextrasdni" name="hsextrasdni" required>
            </div>
          </div>
          <div class="col-xs-8 col-sm-8">
            <div class="form-group">
              <label for="hsextrasempleado" class="control-label">Empleado:</label>
              <input type="text" class="form-control form-control-sm" id="hsextrasempleado" name="hsextrasempleado" disabled>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="hsextrasltrabajo" class="control-label">Lugar de Trabajo:</label>
              <input type="text" class="form-control form-control-sm" id="hsextrasltrabajo" name="hsextrasltrabajo" disabled>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-4 col-sm-4">
            <div class="form-group">
              <label for="hsextrassimples" class="control-label" style="font-size: 13px;">Horas Extras Simples:</label>
              <input type="number" class="form-control form-control-sm" style="font-size: 16px; font-weight: bold;" id="hsextrassimples" name="hsextrassimples" step="0.01" value="0.0">
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group">
              <label for="hsextrasdobles" class="control-label" style="font-size: 13px;">Horas Extras Dobles:</label>
              <input type="number" class="form-control form-control-sm" style="font-size: 16px; font-weight: bold;" id="hsextrasdobles" name="hsextrasdobles" step="0.01" value="0.0">
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group">
              <label for="hsjornales" class="control-label" style="font-size: 13px;">Jornales:</label>
              <input type="number" class="form-control form-control-sm" style="font-size: 16px; font-weight: bold;" id="hsjornales" name="hsjornales" step="0.01" value="0.0">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="hsexobservaciones" class="control-label">Observacones:</label>
              <textarea class="form-control" style="width:100%;height:100px;border: 1px dotted #000099;" name="hsexobservaciones" id="hsexobservaciones"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Actualizar datos</button>
      </div>
    </div>
  </div>
</div>
</form>
<!--<script src="../../vendors/scripts/script.js"></script>-->
<!--
<script src="../../src/plugins/jquery-ui-1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-ui-1.12.1/jquery-ui.css">
-->
<script>

/*
    $(document).ready(function(){
        $("#frm-relojeditar").submit(function(){
            return $(this).validate();
        });
    })
*/
</script>

<script type="text/javascript">
  /*$(document).ready(function(){
    $("#hsextrasdni").autocomplete({
      source: "?c=horasextras&a=HorasExtrasIngresarAyuda",
      //source: "includes/php/horasextrasingresar-ayuda.php",
      minLength: 3,
      select: function(event, ui){
        event.preventDefault();
        $('#hsextrasdni').val(ui.item.nrodocto);
       }
    });
  });*/
</script>
