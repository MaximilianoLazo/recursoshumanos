<form id="" action="?c=legajo&a=HijoModificar" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="HijoModificar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

         <input type="hidden" class="form-control" id="seccion" name="seccion" value="1">
         <input type="text" class="form-control" id="hddapoderadoidn" name="hddapoderadoidn" >
        <input type="text" class="form-control" id="hddjubiladoidn" name="hddjubiladoidn" >

          <div class="row">
            <div class="col-12 col-sm-4 col-md-4">
              <div class="form-group">
                <label for="cbotipodoc" class="control-label">TIPO DNI:</label>
                <select name="cbotipodoc" id="cbotipodoc" class="custom-select form-control" required>
                  <option value="">--Seleccione--</option>
                    <?php foreach($this->model->DniTiposListar() as $row): ?>
                        <option value="<?php echo $row->doctipo_id; ?>"><?php echo $row->doctipo_nombre; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>

              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label for="dni" class="control-label" >N°:</label>
                    <input type="text" class="form-control" id="hdddni" name="hdddni" >
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-xs-12 col-sm-6">

                  <div class="form-group">
                    <label for="dni" class="control-label" >APELLIDO:</label>
                      <input type="text" class="form-control" id="hddape" name="hddape" >
                  </div>
                </div>
                  <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label for="dni" class="control-label" >NOMBRE:</label>
                    <input type="text" class="form-control" id="hddnom" name="hddnom" >
                </div>
              </div>

          </div>
          <div class="row">
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label id="direccion" class="control-label" >DIRECCIÓN:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" >
                </div>
              </div>
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label id="celular" class="control-label" >CELULAR N°:</label>
                    <input type="text" class="form-control" id="celular" name="celular" >
                </div>
              </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnapoderadomodificar" class="btn btn-primary">Modificar</button>
        </div>
      </div>
    </div>
  </div>
</form>
