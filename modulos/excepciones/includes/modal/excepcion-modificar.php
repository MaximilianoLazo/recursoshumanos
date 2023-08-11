<form id="frm-relojeditar" action="?c=excepcion&a=GuardarEx" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateExcepcion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <input type="hidden" class="form-control" id="excepcionid" name="excepcionid">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="excepcionperiodo" class="control-label">Periodo:</label>
              <select name="excepcionperiodo" id="excepcionperiodo" class="custom-select form-control" required>
                  <?php foreach($this->model->Periodos() as $row): ?>
                      <option value="<?php echo $row->periodo_id; ?>"><?php echo $row->periodo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="excepcionfecha" class="control-label">Día:</label>
              <input type="date" class="form-control form-control-sm" id="excepcionfecha" name="excepcionfecha">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="excepcionnrodocto" class="control-label">Nro. Docto:</label>
              <input type="number" class="form-control form-control-sm" id="excepcionnrodocto" name="excepcionnrodocto">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="excepcionhorai" class="control-label">Hora Inicial:</label>
              <input type="time" class="form-control form-control-sm" id="excepcionhorai" name="excepcionhorai">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="excepcionhoraf" class="control-label">Hora Final:</label>
              <input type="time" class="form-control form-control-sm" id="excepcionhoraf" name="excepcionhoraf">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs12 col-sm-12">
            <div class="form-group">
              <div class="form-group">
                <label for="excepcionficha" class="control-label">Ficha?</label>
                <div class="custom-control custom-checkbox mb-5">
                  <input type="checkbox" name="excepcionficha" id="excepcionficha" value="1" class="custom-control-input">
                  <label class="custom-control-label" for="excepcionficha"></label>
                </div>
              </div>
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
