<form id="frm-relojeditar" action="?c=empleado&a=GuardarR" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateFichado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
			<div id="datos_ajax"></div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input type="hidden" class="form-control" id="id" name="id">
              <input type="hidden" class="form-control" id="empid" name="empid">
              <input type="hidden" class="form-control" id="empnrodocto" name="empnrodocto">
              <input type="hidden" class="form-control" id="relojid" name="relojid">
              <input type="hidden" class="form-control" id="accessidup" name="accessidup">
              <input type="hidden" class="form-control" id="semanal" name="semanal">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <h5 class="text-info">Día & Hora de Trabajo</h5>
            </div>
            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="luneshe" class="control-label">Dia: </label>
              <!--<button type="button" class="btn btn-outline-success">Lunes</button>-->
              <h3 class="text-green">Lunes</h3>
              <!--<br>-->
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="luneshe" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="luneshe" name="luneshe">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="luneshs" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="luneshs" name="luneshs">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="moneda" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="lunes" name="lunes" value="1">
                <label class="custom-control-label" for="lunes"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="luneshe" class="control-label">Dia: </label>
              <!--<button type="button" class="btn btn-outline-success">Martes</button>-->
              <h3 class="text-green">Martes</h3>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="marteshe" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="marteshe" name="marteshe">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="marteshs" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="marteshs" name="marteshs">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="moneda" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="martes" name="martes" value="1">
                <label class="custom-control-label" for="martes"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="miercoleshe" class="control-label">Dia: </label>
              <!--<button type="button" class="btn btn-outline-success">Miercoles</button>-->
              <h4 class="text-green">Miercoles</h4>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="miercoleshe" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="miercoleshe" name="miercoleshe">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="miercoleshs" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="miercoleshs" name="miercoleshs">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="moneda" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="miercoles" name="miercoles" value="1">
                <label class="custom-control-label" for="miercoles"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="jueveshe" class="control-label">Dia: </label>
              <!--<button type="button" class="btn btn-outline-success">Jueves</button>-->
              <h3 class="text-green">Jueves</h3>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="jueveshe" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="jueveshe" name="jueveshe">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="jueveshs" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="jueveshs" name="jueveshs">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="moneda" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="jueves" name="jueves" value="1">
                <label class="custom-control-label" for="jueves"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="vierneshe" class="control-label">Dia: </label>
              <!--<button type="button" class="btn btn-outline-success">Viernes</button>-->
              <h3 class="text-green">Viernes</h3>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="vierneshe" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="vierneshe" name="vierneshe">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="vierneshs" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="vierneshs" name="vierneshs">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="moneda" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="viernes" name="viernes" value="1">
                <label class="custom-control-label" for="viernes"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="sabadohe" class="control-label">Dia: </label>
              <!--<button type="button" class="btn btn-outline-warning">Sabado</button>-->
              <h3 class="text-yellow">sabado</h3>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="sabadohe" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="sabadohe" name="sabadohe">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="sabadohs" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="sabadohs" name="sabadohs">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="moneda" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="sabado" name="sabado" value="1">
                <label class="custom-control-label" for="sabado"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="sabadohe" class="control-label">Dia: </label>
              <!--<button type="button" class="btn btn-outline-warning">Domingo</button>-->
              <h4 class="text-yellow">Domingo</h4>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="domingohe" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="domingohe" name="domingohe">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="domingohs" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="domingohs" name="domingohs">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="moneda" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="domingo" name="domingo" value="1">
                <label class="custom-control-label" for="domingo"></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Actualizar datos</button>
      </div>
    </div>
  </div>
</div>
</form>
<script>
/*
    $(document).ready(function(){
        $("#frm-relojeditar").submit(function(){
            return $(this).validate();
        });
    })
*/
</script>
