<form id="" action="?c=legajo&a=CategoriaAlta" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="CategoriaAlta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <h5>Jubilado:</h5>
         <input type="hidden" class="form-control" id="id" name="id">
         <input type="hidden" class="form-control" id="seccion" name="seccion" value="2">
         <input type="text" class="form-control" id="nombr" name="nombr" disabled>
         <input type="hidden" class="form-control" id="seccion" name="seccion" value="1">
          <input type="hidden" class="form-control" id="hddjubiladoidn" name="hddjubiladoidn" >
          <div class="row">
              <div class="col-xs-12 col-sm-4">

                  <div class="form-group">
                    <label for="dni" class="control-label" >CATEGORIA:</label>
                      <input type="text" class="form-control" id="cate" name="cate" required >
                  </div>
                </div>
          </div>
          
          <div class="row">
            <div class="col-xs-12 col-sm-4">
              <div class="form-group">
                  <label for="fecini" class="control-label" >Fecha Inicio:</label>
                  <input type="date" class="form-control" id="fecini" name="fecini" value="" required>
              </div>
            </div>
                                    
            <div class="col-xs-12 col-sm-4">
              <div class="form-group">
                  <label for="fecfin" class="control-label" >Fecha Fin:</label>
                  <input type="date" class="form-control" id="fecfin" name="fecfin" value="" required>
              </div>
            </div>
                          
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-4">
              <div class="form-group">
                  <label for="monto" class="control-label" >Monto:</label>
                  <input type="text" class="form-control" id="monto" name="monto" value="" required>
              </div>
              
            </div>
            <div class="col-xs-12 col-sm-4">
              <div class="form-group">
                  <label for="monto" class="control-label" >Porcentaje Jub.:</label>
                  <input type="text" class="form-control" id="porc" name="porc" value="" required>
              </div>
              
            </div>        
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btncategoriamodificar" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</form>
