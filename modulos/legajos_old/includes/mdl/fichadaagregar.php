<form id="frm-relojeditar" action="?c=empleado&a=GuardarRe" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataAddFichado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <h5 class="text-info">Datos de Reloj</h5>
            </div>
            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-5 col-sm-5">
            <div class="form-group">
              <label for="relojid" class="control-label">Reloj:</label>
              <select name="relojid" id="relojid" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->Relojes() as $row): ?>
                      <option value="<?php echo $row->reloj_id; ?>"><?php echo $row->reloj_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-5 col-sm-4">
            <div class="form-group">
              <label for="accessid" class="control-label">ID:</label>
              <input type="number" class="form-control form-control-sm" id="accessid" name="accessid">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="semanalaad" class="control-label">Semanal?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="semanalaad" name="semanal" value="1">
                <label class="custom-control-label" for="semanalaad"></label>
              </div>
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
              <h3 class="text-green">Lunes</h3>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="lunesheadd" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="lunesheadd" name="lunesheadd">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="luneshsadd" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="luneshsadd" name="luneshsadd">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="lunesadd" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="lunesadd" name="lunesadd" value="1">
                <label class="custom-control-label" for="lunesadd"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="lunesheadd" class="control-label">Dia: </label>
              <h3 class="text-green">Martes</h3>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="martesheadd" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="martesheadd" name="martesheadd">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="marteshsadd" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="marteshsadd" name="marteshsadd">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="martesadd" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="martesadd" name="martesadd" value="1">
                <label class="custom-control-label" for="martesadd"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="miercolesheadd" class="control-label">Dia: </label>
              <h4 class="text-green">Miercoles</h4>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="miercolesheadd" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="miercolesheadd" name="miercolesheadd">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="miercoleshsadd" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="miercoleshsadd" name="miercoleshsadd">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="miercolesadd" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="miercolesadd" name="miercolesadd" value="1">
                <label class="custom-control-label" for="miercolesadd"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="juevesheadd" class="control-label">Dia: </label>
              <h3 class="text-green">Jueves</h3>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="juevesheadd" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="juevesheadd" name="juevesheadd">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="jueveshsadd" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="jueveshsadd" name="jueveshsadd">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="juevesadd" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="juevesadd" name="juevesadd" value="1">
                <label class="custom-control-label" for="juevesadd"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="viernesheadd" class="control-label">Dia: </label>
              <h3 class="text-green">Viernes</h3>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="viernesheadd" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="viernesheadd" name="viernesheadd">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="vierneshsadd" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="vierneshsadd" name="vierneshsadd">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="viernesadd" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="viernesadd" name="viernesadd" value="1">
                <label class="custom-control-label" for="viernesadd"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="sabadoheadd" class="control-label">Dia: </label>
              <h3 class="text-yellow">sabado</h3>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="sabadoheadd" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="sabadoheadd" name="sabadoheadd">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="sabadohsadd" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="sabadohsadd" name="sabadohsadd">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="sabadoadd" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="sabadoadd" name="sabadoadd" value="1">
                <label class="custom-control-label" for="sabadoadd"></label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="domingoadd" class="control-label">Dia: </label>
              <h4 class="text-yellow">Domingo</h4>
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="domingoheadd" class="control-label">Entrada:</label>
              <input type="time" class="form-control form-control-sm" id="domingoheadd" name="domingohe">
            </div>
          </div>
          <div class="col-xs-5 col-sm-3">
            <div class="form-group">
              <label for="domingohsadd" class="control-label">Salida:</label>
              <input type="time" class="form-control form-control-sm" id="domingohsadd" name="domingohsadd">
            </div>
          </div>
          <div class="col-xs-2 col-sm-1">
            <div class="form-group">
              <label for="domingoadd" class="control-label">Ficha?</label>
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" class="custom-control-input" id="domingoadd" name="domingoadd" value="1">
                <label class="custom-control-label" for="domingoadd"></label>
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
