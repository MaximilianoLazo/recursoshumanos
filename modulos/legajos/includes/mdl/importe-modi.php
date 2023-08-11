<form id="" action="?c=legajo&a=ImporteModificar" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="ImporteModificar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

                <input type="hidden" class="form-control" id="seccion" name="seccion" value="1">
          
                <input type="hidden" class="form-control" id="id" name="id" >
                <input type="text" class="form-control" id="nombre1" name="nombre1" disabled >
                <input type="hidden" class="form-control" id="hddhaber1" name="hddhaber1"  >
              
                <input type="hidden" class="form-control" id="hddanio" name="hddanio"  >
                        
                <div class="row">
                  <div class="col-xs-12 col-sm-4">
                    <div class="form-group">
                        <label for="monto" class="control-label" >Monto:</label>
                        <input type="text" class="form-control" id="hddimporte" name="hddimporte" >
                    </div>
                    
                  </div>
                  <div class="col-xs-12 col-sm-4">
                    <div class="form-group">
                        <label for="monto" class="control-label" >Porcentaje Jub.:</label>
                        <input type="text" class="form-control" id="hddporant" name="hddporant" value="" >
                    </div>
                    
                  </div>
                  
                  <div class="row">
                      <div class="col-xs-12 col-sm-4">

                        <div class="form-group">
                          <label for="dni" class="control-label" >Categoría:</label>
                            <input type="text" class="form-control" id="hddcat" name="hddcat" >
                        </div>
                      </div>
                  </div> 
                </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnimportemodificar" class="btn btn-primary">Modificar</button>
        </div>
      </div>
    </div>
  </div>
</form>
