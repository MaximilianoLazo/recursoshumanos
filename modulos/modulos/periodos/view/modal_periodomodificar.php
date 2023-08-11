<form id="frm-relojeditar" action="?c=periodo&a=GuardarP" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdatePeriodo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <input type="hidden" class="form-control" id="perid" name="perid">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="pernombre" class="control-label"><h5 class="text-blue">Periodo:</h5></label>
              <h6 class="text-green">AAAAMM</h6>
              <input type="number" class="form-control form-control-sm" id="pernombre" name="pernombre">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs 12 col-sm-12">
            <div class="form-group">
              <label for="jueveshe" class="control-label"><h5 class="text-blue">Horas Extras y Jornal:</h5></label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-5 col-sm-6">
            <div class="form-group">
              <h6 class="text-green">Desde:</h6>
              <input type="date" class="form-control form-control-sm" id="perhorasjori" name="perhorasjori">
            </div>
          </div>
          <div class="col-xs-5 col-sm-6">
            <div class="form-group">
              <h6 class="text-green">Hasta:</h6>
              <input type="date" class="form-control form-control-sm" id="perhorasjorf" name="perhorasjorf">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs 12 col-sm-12">
            <div class="form-group">
              <label for="jueveshe" class="control-label"><h5 class="text-blue">Presentismo:</h5></label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-5 col-sm-6">
            <div class="form-group">
              <h6 class="text-green">Desde:</h6>
              <input type="date" class="form-control form-control-sm" id="perpresentismoi" name="perpresentismoi">
            </div>
          </div>
          <div class="col-xs-5 col-sm-6">
            <div class="form-group">
              <h6 class="text-green">Hasta:</h6>
              <input type="date" class="form-control form-control-sm" id="perpresentismof" name="perpresentismof">
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
