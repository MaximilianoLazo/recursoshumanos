<form id="" action="?c=legajo&a=FamiliarEditar" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="FamiliarEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <?php $escolaridad=false; $discapacidad=false;?>
        <div class="modal-body">
	         <h5>Hijo de:</h5>
          <input type="hidden" class="form-control" id="id" name="id">
          <input type="hidden" class="form-control" id="seccion" name="seccion" value="2">
          <input type="text" class="form-control" id="nombr" name="nombr" disabled>
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-lg-6">
                  <div class="form-group">
                  <label for="cbotipodoc" class="control-label">Tipo Documento:</label>
                  <select name="cbotipodoc" id="cbotipodoc" class="custom-select form-control" >
                    <option></option>
                      <?php foreach($this->model->DniTiposListar() as $row): ?>
                        <option value="<?php echo $row->doctipo_id; ?>"><?php echo $row->doctipo_nombre;?> </option>
                      <?php endforeach; ?>
                  </select>
                  </div>
            </div>
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="dni" class="control-label" >DNI:</label>
                    <input type="text" class="form-control" value="" id="hdddni" name="hdddni" >
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="dni" class="control-label" >Apellido:</label>
                    <input type="text" class="form-control" id="hddapellido" name="hddapellido" value="" >
                </div>
              </div>

              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="dni" class="control-label" >Nombres:</label>
                    <input type="text" class="form-control" id="hddnombre" name="hddnombre" value="" >
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    <label for="fecnac" class="control-label" >Fecha Nacimiento:</label>
                    <input type="date" class="form-control" id="fecnac" name="fecnac" value="" >
                </div>
              </div>

          <div class="col-12 col-sm-4 col-md-4">
            <div class="form-group">
              <label for="cbosexo" class="control-label" >Sexo:</label>
              <select name="cbosexo" id="cbosexo" class="custom-select form-control" >
                 <option></option>
                   <?php foreach($this->model->SexoListar() as $row):  ?>
                       <option value="<?php echo $row->sexo_id; ?>"><?php  echo $row->sexo_nombre;?> </option>
                   <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-12 col-sm-4 col-md-4">
            <div class="form-group">
              <label for="cboecivil" class="control-label">Estado Civil:</label>
              <select name="cboecivil" id="cboecivil" class="custom-select form-control" >
                 <option></option>
                 <?php foreach($this->model->EstadoCivilListar() as $row): ?>
                 <option value="<?php echo $row->estcivil_id; ?>"><?php echo $row->estcivil_nombre;?> </option>
                   <?php endforeach; ?>
             </select>
            </div>
          </div>
            </div>
          <div class="row">
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label id="direccion" class="control-label" >Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="" >
                </div>
              </div>

          <div class="col-xs-12 col-sm-6 col-lg-6">
                <div class="form-group">
                <label for="cbolocalidad" class="control-label">Localidad:</label>
                <select name="cbolocalidad" id="cbolocalidad" class="custom-select form-control" >
                  <option></option>
                    <?php foreach($this->model->LocalidadListar() as $row): ?>
                      <option value="<?php echo $row->localidad_id; ?>"><?php echo $row->localidad_nombre;?> </option>
                    <?php endforeach; ?>
                </select>
                </div>
          </div>

        </div>
          <td class="colleft"><label for="checescolaridad">Discapacidad?</label></td>
          <td class="colrite">
              <input type="checkbox" id="checdiscapacidad" name="checdiscapacidad" onchange="javascript:mostrar()"
                <?php if ($discapacidad != '') {echo "checked";} ?> value="<?php echo $discapacidad; ?>">
          </td>
          <td class="colleft"><label for="checescolaridad">Escolaridad</label></td>
          <td class="colrite">
              <input type="checkbox" id="checescolaridad" name="checescolaridad" onchange="javascript:mostrar()"
                <?php if ($escolaridad != '') {echo "checked";} ?> value="<?php echo $escolaridad; ?>">
          </td>
          <div class="row">
          <div class="col-xs-12 col-sm-6 col-lg-6" id="comboescuela" name="comboescuela" style="display: none;">
                <div class="form-group">
                <label for="cboescuela" class="control-label">Escuela:</label>
                <select name="cboescuela" id="cboescuela" class="custom-select form-control" >
                  <option></option>
                    <?php foreach($this->model->EscuelaListar() as $row): ?>
                      <option value="<?php echo $row->escuela_id; ?>"><?php echo $row->escuela_nombre;?> </option>
                    <?php endforeach; ?>
                </select>
                </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-lg-6" id="comboescolar" name="comboescolar" style="display: none;">
                <div class="form-group">
                <label for="cbonivel" class="control-label">Nivel:</label>
                <select name="cbonivel" id="cbonivel" class="custom-select form-control" >
                  <option></option>
                    <?php foreach($this->model->NivelListar() as $row): ?>
                      <option value="<?php echo $row->escuela_nivel_id; ?>"><?php echo $row->escuela_nivel_nombre;?> </option>
                    <?php endforeach; ?>
                </select>
                </div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnfamiliarmodificar" class="btn btn-primary">Agregar</button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
      function mostrar() {
          element = document.getElementById("comboescolar");
          element1 = document.getElementById("comboescuela");
          check = document.getElementById("checescolaridad");
          if (checescolaridad.checked) {
              element.style.display='block';
              element1.style.display='block';
          }
          else {
              element.style.display='none';
              element1.style.display='none';
          }
      }
  </script>

</form>
