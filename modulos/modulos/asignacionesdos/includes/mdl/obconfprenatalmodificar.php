<form id="frm-relojeditar" action="?c=asignacion&a=GuardarContrato" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateOBConfPreNatal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <input type="hidden" class="form-control" id="obcpniduno" name="obcpniduno">
              <input type="hidden" class="form-control" id="obcpniddos" name="obcpniddos">
              <input type="hidden" class="form-control" id="obcpnidtres" name="obcpnidtres">
              <input type="hidden" class="form-control" id="obcpnidcuatro" name="obcpnidcuatro">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobcpndesdeunoed" class="control-label">Desde:</label>
              <input type="text" class="form-control form-control-sm" id="txtobcpndesdeunoed" name="txtobcpndesdeunoed" placeholder="#" disabled>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobcpnhastaunoed" class="control-label">Hasta:</label>
              <input type="text" class="form-control form-control-sm" id="txtobcpnhastaunoed" name="txtobcpnhastaunoed">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobcpndesdedosed" class="control-label">Desde:</label>
              <input type="text" class="form-control form-control-sm" id="txtobcpndesdedosed" name="txtobcpndesdedosed">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobcpnhastadosed" class="control-label">Hasta:</label>
              <input type="text" class="form-control form-control-sm" id="txtobcpnhastadosed" name="txtobcpnhastadosed">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobcpndesdetresed" class="control-label">Desde:</label>
              <input type="text" class="form-control form-control-sm" id="txtobcpndesdetresed" name="txtobcpndesdetresed">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobcpnhastatresed" class="control-label">Hasta:</label>
              <input type="text" class="form-control form-control-sm" id="txtobcpnhastatresed" name="txtobcpnhastatresed">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobcpndesdecuatroed" class="control-label">Desde:</label>
              <input type="text" class="form-control form-control-sm" id="txtobcpndesdecuatroed" name="txtobcpndesdecuatroed">
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtobcpnhastacuatroed" class="control-label">Hasta:</label>
              <input type="text" class="form-control form-control-sm" id="txtobcpnhastacuatroed" name="txtobcpnhastacuatroed" placeholder="#" disabled>
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
