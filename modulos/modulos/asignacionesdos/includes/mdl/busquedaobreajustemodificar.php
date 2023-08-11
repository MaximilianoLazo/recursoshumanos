<form id="frm-relojeditar" action="?c=asignacion&a=GuardarOBReajuste" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateReajuste" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <input type="hidden" class="form-control" id="ndocconsultado" name="ndocconsultado">
              <input type="hidden" class="form-control" id="importeob" name="importeob">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="txtasignacionnrodocto" class="control-label">Nro. Docto:</label>
              <!--<input type="number" class="form-control form-control-sm" id="txtasignacionnrodocto" name="txtasignacionnrodocto">-->

              <div class="alert alert-info" role="alert">
                <h6 class="text-primary hijondoc" id="hijondoc"></h6>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="txtasignaciont" class="control-label">Apellido:</label>
              <!--<input type="text" class="form-control form-control-sm" id="txtasignaciont" name="txtasignaciont">-->

              <div class="alert alert-info" role="alert">
                <h6 class="text-primary hijoapellido" id="hijoapellido"></h6>
              </div>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <label for="TxtEmpFechaFinalizacionAdd" class="control-label">Nombres:</label>
              <!--<input type="date" class="form-control form-control-sm" id="TxtEmpFechaFinalizacionAdd" name="TxtEmpFechaFinalizacionAdd">-->

              <div class="alert alert-info" role="alert">
                <h6 class="text-primary hijonombres" id="hijonombres"></h6>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="txtasignaciont" class="control-label">Tipo de Asignacion:</label>
              <!--<input type="text" class="form-control form-control-sm" id="txtasignaciont" name="txtasignaciont">-->

              <div class="alert alert-info" role="alert">
                <h6 class="text-primary asigobtipo" id="asigobtipo"></h6>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-4 col-sm-4">
            <div class="form-group">
              <label for="asigobimporte" class="control-label">Importe $:</label>
              <input type="number" class="form-control form-control-sm" id="asigobimporte" name="asigobimporte" onkeyup="sumar()" step="0.01" disabled>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group">
              <label for="txtasignacionr" class="control-label">Reajuste $:</label>
              <input type="number" class="form-control form-control-sm" id="txtasignacionr" name="txtasignacionr" onkeyup="sumar()" step="0.01">
            </div>
          </div>
          <div class="col-xs-4 col-sm-4">
            <div class="form-group">
              <label for="txtasignacionimpt" class="control-label">Total $:</label>
              <input type="number" class="form-control form-control-sm" id="txtasignacionimpt" name="txtasignacionimpt" step="0.01" disabled>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="txtasignacionobs" class="control-label">Observacones:</label>
              <textarea class="form-control" rows="3" cols="10" name="txtasignacionobs" id="txtasignacionobs"></textarea>
            </div>
          </div>
        </div>
        <div class="row">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar datos</button>
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
  function sumar(){
    //
    valor1 = eval(document.getElementById('asigobimporte').value);
    valor2 = eval(document.getElementById('txtasignacionr').value);
    total = valor1 + valor2;
    document.getElementById('txtasignacionimpt').value = total;
  }
</script>
<script language="javascript">
/*
  function sumar(){
    //
    var total = 0;
    var valor1 = document.getElementById("asigobimporte")
    var valor2 = document.getElementById("txtasignacionr")

    total.value = parseInt(asigobimporte.value) + parseInt(txtasignacionr.value);

    var Display = document.getElementById("txtasignaciont");
    Display.innerHTML = total;
  }
  */
</script>
