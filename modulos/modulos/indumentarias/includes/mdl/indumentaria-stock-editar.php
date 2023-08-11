<form id="#" action="?c=indumentaria&a=IndumentariaStockGuardar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="IndumentariaStockEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="hddindstockide" name="hddindstockide">
          <input type="hidden" class="form-control" id="hddindstockcantidade" name="hddindstockcantidade">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="cboindstocknombree" class="control-label">Indumentaria:</label>
                <select name="cboindstocknombree" id="cboindstocknombree" class="custom-select form-control" required>
                  <option value="">--Seleccione--</option>
                    <?php foreach($this->model->IndumentariaListar() as $row): ?>
                        <option value="<?php echo $row->indumentaria_id; ?>"><?php echo $row->indumentaria_nombre; ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text" id="smlindstocknombree" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-6">
              <div class="form-group">
                <label for="cboindstocktallee" class="control-label">Talle: </label>
                <select name="cboindstocktallee" id="cboindstocktallee" class="custom-select form-control" required>
                  <option value="">--Seleccione--</option>
                </select>
                <small class="form-text" id="smlindstocktallee" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6">
              <div class="form-group">
                <label for="cboindstockcolore" class="control-label">Color:</label>
                <select name="cboindstockcolore" id="cboindstockcolore" class="custom-select form-control" required>
                  <option value="">--Seleccione--</option>
                    <?php foreach($this->model->IndumentariaColorListar() as $row): ?>
                        <option value="<?php echo $row->indumentaria_color_id; ?>"><?php echo $row->indumentaria_color_nombre; ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text" id="smlindstockcolore" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtindstockcbarrase" class="control-label">Codigo de Barras: </label>
                <input type="text" name="txtindstockcbarrase" id="txtindstockcbarrase" class="form-control form-control-sm" placeholder="" required/>
                <small class="form-text" id="smlindstockcbarrase" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-4">
              <div class="form-group">
                <label for="txtindstockcantidade" class="control-label">Stock: </label>
                <input type="number" name="txtindstockcantidade" id="txtindstockcantidade" class="form-control form-control-sm" placeholder="" required/>
                <small class="form-text" id="smlindstockcantidade" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
            <div class="col-xs-12 col-sm-4">
              <div class="form-group">
                <label for="txtindstockcantidadmine" class="control-label">Stock Minimo: </label>
                <input type="number" name="txtindstockcantidadmine" id="txtindstockcantidadmine" class="form-control form-control-sm" placeholder="" required/>
                <small class="form-text" id="smlindstockcantidadmine" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
            <div class="col-xs-12 col-sm-4">
              <div class="form-group">
                <label for="txtindstockcantidadacte" class="control-label">Stock Actual: </label>
                <input type="number" name="txtindstockcantidadacte" id="txtindstockcantidadacte" class="form-control form-control-sm" placeholder="" required/>
                <small class="form-text" id="smlindstockcantidadacte" style="color: #9a9a9a">* Campo requerido</small>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnindcarroadd" class="btn btn-primary">AGREGAR</button>
        </div>
      </div>
    </div>
  </div>
</form>
