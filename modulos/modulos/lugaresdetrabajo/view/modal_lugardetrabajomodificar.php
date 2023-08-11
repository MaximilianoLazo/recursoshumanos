<form id="frm-relojeditar" action="?c=lugardetrabajo&a=GuardarL" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateLugarDeTrabajo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
			<div id="datos_ajax"></div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input type="hidden" class="form-control" id="trabajoid" name="trabajoid">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="pernombre" class="control-label"><h5 class="text-green">Lugar de Trabajo:</h5></label>
              <input type="text" class="form-control form-control-sm" id="trabajonombre" name="trabajonombre">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="pernombre" class="control-label"><h5 class="text-green">Secretaria:</h5></label>
              <select name="trabajosec" id="trabajosec" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->Secretarias() as $row): ?>
                      <option value="<?php echo $row->secretaria_id; ?>"><?php echo $row->secretaria_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
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
<script>
/*
    $(document).ready(function(){
        $("#frm-relojeditar").submit(function(){
            return $(this).validate();
        });
    })
*/
</script>
