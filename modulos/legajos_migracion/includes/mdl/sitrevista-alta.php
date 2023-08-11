<form id="" action="?c=legajo&a=SitRevistaAlta" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="SitRevistaAlta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

         <input type="hidden" class="form-control" id="seccion" name="seccion" value="1">
          <input type="text" class="form-control" id="hddjubiladoidn" name="hddjubiladoidn" >

          <div class="row">
            <div class="col-12 col-sm-4 col-md-4">
              <div class="form-group">
                <label for="cbotipodoc" class="control-label" >SITUACION DE REVISTA:</label>
                <select name="cbotipodoc" id="cbotipodoc" class="custom-select form-control" >
                   <option value="">-- SELECCIONE --</option>
                     <?php foreach($this->model->JubiladoTiposListar() as $row):  ?>
                         <option value="<?php echo $row->legajo_tipo_id; ?>"> <?php  echo $row->legajo_tipo_nombre;?> </option>
                     <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-12 col-sm-4 col-md-4">
              <div class="form-group">
                <label for="cbotipojub" class="control-label" >TIPO DE JUBILACION:</label>
                <select name="cbotipojub" id="cbotipojub" class="custom-select form-control" >
                   <option value="">-- SELECCIONE --</option>
                     <?php foreach($this->model->JubiladoTiposJubilacion() as $row):  ?>
                         <option value="<?php echo $row->categoria_jub_id; ?>"> <?php  echo $row->categoria_jub_abreviacion;?> </option>
                     <?php endforeach; ?>
                </select>
              </div>
            </div>

          </div>

          <div class="row">
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label id="sucursal" class="control-label" >SUCURSAL:</label>
                    <input type="text" class="form-control" id="sucursal" name="sucursal" >
                </div>
              </div>
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label id="cuenta" class="control-label" >N° DE CUENTA:</label>
                    <input type="text" class="form-control" id="cuenta" name="cuenta" >
                </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnbancomodificar" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</form>
