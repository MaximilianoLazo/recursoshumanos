<form id="#" action="?c=indumentaria&a=IndumentariaColorGuardar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="IndumentariaColorEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="hddindcoloride" name="hddindcoloride">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtindcolornombree" class="control-label">Color de Indumentaria:</label>
                <input type="text" name="txtindcolornombree" id="txtindcolornombree" class="form-control form-control-sm" placeholder="" required/>
                <small class="form-text" id="smlindtiponombree" style="color: #9a9a9a">* Campo requerido</small>
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
