<form id="" action="?c=liquidacion&a=JubiladoNovedad" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="JubiladoNovedad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <h2 class="display-4">ATENCIÓN!</h2>
          <input type="hidden" class="form-control" id="id" name="id">
          <input type="hidden" class="form-control" id="seccion" name="seccion" value="0">
          <input type="hidden" class="form-control" id="periodo" name="periodo" value="0">
          <input type="hidden" class="form-control" id="anio" name="anio" value="0">
          <input type="hidden" class="form-control" id="mes" name="mes" value="0">
          <div class="row">
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                   <label for="nombre" class="control-label">Nombre y Apellido: </label>
                    <input type="text" class="form-control" id="hddnombre" name="hddnombre">
                </div>
              </div>
          </div>
          <div class="row">
              <label for="dn" class="control-label">DNI: </label>
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <input type="text" class="form-control" id="hdddni" name="hdddni">
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                   <label for="fe" class="control-label">Fecha Jubilación: </label>
                    <input type="Date" class="form-control" id="textfecha" name="textfecha" value=""  >
                </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnjubiladoeditar" class="btn btn-primary">Iniciar Julación</button>
        </div>
      </div>
    </div>
  </div>
</form>
