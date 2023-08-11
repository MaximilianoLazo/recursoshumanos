<form id="#" action="?c=empleado&a=HijoEscGuardar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="dataUpdateEscuelaHijo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
                <input type="hidden" class="form-control" name="eschijoid" id="eschijoid">
                <input type="hidden" class="form-control" name="escempid" id="escempid">
                <input type="hidden" class="form-control" name="escempndoc" id="escempndoc">
                <input type="hidden" class="form-control" name="escbenndoc" id="escbenndoc">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="hijoescnom" class="control-label">Escuela: </label>
                <select name="hijoescnom" id="hijoescnom" class="custom-select2 form-control select2-hidden-accessible" style="width: 100%; height: 38px;" tabindex="-1" aria-hidden="true" required>
                  <option value="">--Seleccione--</option>
                    <?php foreach($this->model->Escuelas() as $row): ?>
                        <option value="<?php echo $row->escuela_id; ?>"><?php echo $row->escuela_nombre." Nro ".$row->escuela_numero; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="hijoescnvl" class="control-label">Nivel:</label>
                <select name="hijoescnvl" id="hijoescnvl" class="custom-select form-control" required>
                  <option value="">--Seleccione--</option>
                    <?php foreach($this->model->EscuelasNivel() as $row): ?>
                        <option value="<?php echo $row->escnivel_id; ?>"><?php echo $row->escnivel_nombre; ?></option>
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
