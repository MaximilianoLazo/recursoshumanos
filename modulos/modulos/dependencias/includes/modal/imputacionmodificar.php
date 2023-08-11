<form id="frm-imputacioneditar" action="?c=imputacion&a=GuardarI" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateImputacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <input type="hidden" class="form-control" id="imputacionid" name="imputacionid">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="imputacioncodigow" class="control-label">Codigo W:</label>
              <input type="text" class="form-control form-control-sm" id="imputacioncodigow" name="imputacioncodigow">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="imputacioncodigos" class="control-label">Codigo S:</label>
              <input type="number" class="form-control form-control-sm" id="imputacioncodigos" name="imputacioncodigos">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="imputacionnombre" class="control-label">Nombre de Imputación:</label>
              <input type="text" class="form-control form-control-sm" id="imputacionnombre" name="imputacionnombre">
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
