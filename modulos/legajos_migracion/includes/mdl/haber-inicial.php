<form id="" action="?c=legajo&a=GenerarHaberInicial" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="GenerarHaberInicial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

         <input type="hidden" class="form-control" id="seccion" name="seccion" value="1">
  
        <input type="hidden" class="form-control" id="id" name="id" >
        <input type="text" class="form-control" id="hddnombre" name="hddnombre" disabled >
   
        
          <div class="row">
              <div class="col-xs-12 col-sm-6">

                  <div class="form-group">
                    <label for="dni" class="control-label" >Haber Jubilatorio1:</label>
                      <input type="text" class="form-control" id="hddimporte" name="hddimporte" >
                  </div>
                </div>
              </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnhaberinicial" class="btn btn-primary">Generar</button>
        </div>
      </div>
    </div>
  </div>
</form>
