<form id="frm-conyugeagregar" action="?c=empleado&a=GuardarEmpleado" method="post" enctype="multipart/form-data">
<div class="modal fade bd-example-modal-lg" id="dataAddEmpleado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
      <div id="datos_ajax"></div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <input type="hidden" class="form-control" id="empleadoid" name="empleadoid">
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <!--
            <div class="form-group">
              <label for="emptdoc" class="control-label">T DOC: </label>
              <select name="emptdoc" id="emptdoc" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php //foreach($this->model->TiposDocto() as $row): ?>
                      <option value="<?php //echo $row->doctipo_id; ?>"><?php //echo $row->doctipo_abreviacion; ?></option>
                  <?php //endforeach; ?>
              </select>
            </div>
          -->
          </div>

          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="empnrodocumento" class="control-label">DNI:</label>
              <input type="text" name="empnrodocumento" id="empnrodocumento" class="form-control form-control-sm" placeholder="Ej: 22330150" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="empcuil" class="control-label">CUIL: </label>
              <input type="text" name="empcuil" id="empcuil" class="form-control form-control-sm" placeholder="Ej: 20-22330150-4" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="empnroleg" class="control-label">Nro de Legajo:</label>
              <input type="text" name="empnroleg" id="empnroleg" class="form-control form-control-sm" placeholder="Ej: 365899" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">

          </div>
          <div class="col-xs-12 col-sm-9">
            <div class="form-group">
              <label for="empapellido" class="control-label">Apellido: </label>
              <input type="text" name="empapellido" id="empapellido" class="form-control form-control-sm" placeholder="Ej: Gonzalez" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">

          </div>
          <div class="col-xs-12 col-sm-9">
            <div class="form-group">
              <label for="empnombres" class="control-label">Nombres:</label>
              <input type="text" name="empnombres" id="empnombres" class="form-control form-control-sm" placeholder="Ej: Jose Luis" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12 col-sm-3">
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group">
              <label for="empsexo" class="control-label">Sexo:</label>
              <select name="empsexo" id="empsexo" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->Sexos() as $row): ?>
                      <option value="<?php echo $row->sexo_id; ?>"><?php echo $row->sexo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-5">
            <div class="form-group">
              <label for="empestcivil" class="control-label">Estado Civil:</label>
              <select name="empestcivil" id="empestcivil" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->EstadosC() as $row): ?>
                      <option value="<?php echo $row->estcivil_id; ?>"><?php echo $row->estcivil_nombre; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <!--
          <div class="col-xs-12 col-sm-1">
          </div>
        -->


        </div>


        <div class="row">
          <div class="col-xs-12 col-sm-3">

          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group">
              <label for="empfecnacto" class="control-label">Fecha de Nacimiento:</label>
              <input type="date" name="empfecnacto" id="empfecnacto" class="form-control form-control-sm" placeholder="Ej: 02/10/1981" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-5">
            <div class="form-group">
              <label for="empfecing" class="control-label">Fecha de Ingreso:</label>
              <input type="date" name="empfecing" id="empfecing" class="form-control form-control-sm" placeholder="Ej: 02/10/1981" required>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">AGREGAR DATOS</button>
      </div>
    </div>
  </div>
</div>
</form>
<script type="text/javascript">
/*
    $(document).ready(function(){
        $("#frm-conyugeagregar").submit(function(){
            return $(this).validate();
        });
    })
*/
</script>
