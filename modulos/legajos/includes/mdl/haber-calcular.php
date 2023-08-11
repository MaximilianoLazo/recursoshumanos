<form id="" action="?c=legajo&a=HaberEditar" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="HaberEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
	         <h5>Jubilado:</h5>
          <input type="hidden" class="form-control" id="id" name="id">
          <input type="hidden" class="form-control" id="seccion" name="seccion" value="5">
          <input type="text" class="form-control" id="nombr" name="nombr" disabled>
          <input type="text" class="form-control" id="per" name="per" >
          <input type="text" class="form-control" id="anio" name="anio" >

          <div class="row">
              <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    <label for="fecnac" class="control-label" >Fecha Jubilación:</label>
                    <input type="date" class="form-control" id="fecnac" name="fecnac" value="" disabled>
                </div>
              </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnhabermodificar" class="btn btn-primary">Agregar</button>
        </div>
      </div>
    </div>
  </div>


</form>
