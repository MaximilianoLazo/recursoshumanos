<form id="frmcarroeditar" action="" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="IndumentariaCarroEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="hddempide" name="hddempide">
          <input type="hidden" class="form-control" id="hddempnrodoctoe" name="hddempnrodoctoe">
          <input type="hidden" class="form-control" id="hddindentregaide" name="hddindentregaide">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="cboindcarronombree" class="control-label">Indumentaria:</label>
                <select name="cboindcarronombree" id="cboindcarronombree" class="custom-select form-control" required>
                  <option value="">--Seleccione--</option>
                    <?php foreach($this->model->IndumentariaListar() as $row): ?>
                        <option value="<?php echo $row->indumentaria_id; ?>"><?php echo $row->indumentaria_nombre; ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text" id="smlindumentaria" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-4">
              <div class="form-group">
                <label for="cboindcarrotallee" class="control-label">Talle: </label>
                <select name="cboindcarrotallee" id="cboindcarrotallee" class="custom-select form-control" required>
                  <option value="">--Seleccione--</option>
                </select>
                <small class="form-text" id="smltalle" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
            <div class="col-xs-12 col-sm-4">
              <div class="form-group">
                <label for="cboindcarrocolore" class="control-label">Color:</label>
                <select name="cboindcarrocolore" id="cboindcarrocolore" class="custom-select form-control" required>
                  <option value="">--Seleccione--</option>
                    <?php foreach($this->model->IndumentariaColorListar() as $row): ?>
                        <option value="<?php echo $row->indumentaria_color_id; ?>"><?php echo $row->indumentaria_color_nombre." - <strong><i>100</i></strong>"; ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text" id="smlcolor" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
            <div class="col-xs-12 col-sm-4">
              <div class="form-group">
                <label for="txtindcarrocantidade" class="control-label">Cantidad: </label>
                <input type="number" name="txtindcarrocantidade" id="txtindcarrocantidade" class="form-control form-control-sm" placeholder="" required/>
                <small class="form-text" id="smlcantidad" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtindcarroobse" class="control-label">Observaciones:</label>
                <textarea style="width:100%;height:80px;border: 1px solid #ccc;" class="form-control" name="txtindcarroobse" id="txtindcarroobse"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="btnindcarroadd" class="btn btn-primary">AGREGAR</button>
        </div>
      </div>
    </div>
  </div>
</form>
<style media="screen">

/*input:invalid {
    border-color: #ccc;
}

input,
input:valid {
    border-color: #ccc;
}*/
</style>
