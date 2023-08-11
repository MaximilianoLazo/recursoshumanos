<form id="frm-estudioeditar" action="?c=empleado&a=GuardarEs" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateEstudio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <input type="hidden" class="form-control" id="id" name="id">
              <input type="hidden" class="form-control" id="empid" name="empid">
              <input type="hidden" class="form-control" id="empnrodocto" name="empnrodocto">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="estudioesc" class="control-label">Escuela / Institulo:</label>
              <select name="estudioesc" id="estudioesc" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->Escuelas() as $row): ?>
                      <option value="<?php echo $row->escuela_id; ?>"><?php echo $row->escuela_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="estudionvl" class="control-label">Nivel:</label>
              <select name="estudionvl" id="estudionvl" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->EscuelasNivel() as $row): ?>
                      <option value="<?php echo $row->escnivel_id; ?>"><?php echo $row->escnivel_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="estudioestado" class="control-label">Estado:</label>
              <select name="estudioestado" id="estudioestado" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->EscuelasEstado() as $row): ?>
                      <option value="<?php echo $row->escestado_id; ?>"><?php echo $row->escestado_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="estudiotitulo" class="control-label">Titulo:</label>
              <input type="text" name="estudiotitulo" id="estudiotitulo" class="form-control form-control-sm" placeholder="" required>
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
        $("#frm-estudioeditar").submit(function(){
            return $(this).validate();
        });
    })
*/  
</script>
