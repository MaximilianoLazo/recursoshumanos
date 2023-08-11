<form id="frm-relojeditar" action="?c=asignacion&a=GuardarContrato" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateOBConfHijo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input type="hidden" class="form-control" id="obchiduno" name="obchiduno">
              <input type="hidden" class="form-control" id="obchiddos" name="obchiddos">
              <input type="hidden" class="form-control" id="obchidtres" name="obchidtres">
              <input type="hidden" class="form-control" id="obchidcuatro" name="obchidcuatro">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobchdesdeunoed" class="control-label">Desde:</label>
              <input type="text" class="form-control form-control-sm" id="txtobchdesdeunoed" name="txtobchdesdeunoed" placeholder="#" disabled>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobchhastaunoed" class="control-label">Hasta:</label>
              <input type="text" class="form-control form-control-sm" id="txtobchhastaunoed" name="txtobchhastaunoed">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobchdesdedosed" class="control-label">Desde:</label>
              <input type="text" class="form-control form-control-sm" id="txtobchdesdedosed" name="txtobchdesdedosed">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobchhastadosed" class="control-label">Hasta:</label>
              <input type="text" class="form-control form-control-sm" id="txtobchhastadosed" name="txtobchhastadosed">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobchdesdetresed" class="control-label">Desde:</label>
              <input type="text" class="form-control form-control-sm" id="txtobchdesdetresed" name="txtobchdesdetresed">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobchhastatresed" class="control-label">Hasta:</label>
              <input type="text" class="form-control form-control-sm" id="txtobchhastatresed" name="txtobchhastatresed">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobchdesdecuatroed" class="control-label">Desde:</label>
              <input type="text" class="form-control form-control-sm" id="txtobchdesdecuatroed" name="txtobchdesdecuatroed">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobchhastacuatroed" class="control-label">Hasta:</label>
              <input type="text" class="form-control form-control-sm" id="txtobchhastacuatroed" name="txtobchhastacuatroed" placeholder="#" disabled>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar datos</button>
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
