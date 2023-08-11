<form id="frm-tabladeactividadeseditar" action="?c=imputacion&a=GuardarIAC" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateTablaDeActividades" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <input type="hidden" class="form-control" id="impactividadid" name="impactividadid">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="impactividadcodigos" class="control-label">Codigo S:</label>
              <input type="number" class="form-control form-control-sm" id="impactividadcodigos" name="impactividadcodigos">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="impactividadnombre" class="control-label">Nombre de Actividad:</label>
              <input type="text" class="form-control form-control-sm" id="impactividadnombre" name="impactividadnombre">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="imputacionnombre" class="control-label">Imputacion:</label>
              <select name="imputacionnombre" id="imputacionnombre" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->ListarImputaciones() as $row): ?>
                      <option value="<?php echo $row->imputacion_id; ?>"><?php echo $row->imputacion_nombre; ?></option>
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
