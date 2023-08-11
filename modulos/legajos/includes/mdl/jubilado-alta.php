<form id="" action="?c=legajo&a=JubiladoAlta" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="JubiladoAlta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
              <input type="hidden" class="form-control" id="seccion" name="seccion" value="1">
              
              <div class="col-xs-12 col-sm-6"> 
                  <div class="form-group">
                    <label for="fe" class="control-label">Fecha Jubilación: </label>
                      <input type="Date" class="form-control" id="textfechajub" name="textfechajub" required>
                  </div>
              </div>
                            
              <div class="row">

                    <div class="col-xs-12 col-sm-6">
                      <div class="form-group">
                          <label for="cbotipodoc" class="control-label">NOMBRE:</label>
                          <input type="text" class="form-control" id="hddnombre" name="hddnombre" >
                      </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                      <div class="form-group">
                          <label for="cbotipodoc" class="control-label">APELLIDO:</label>
                          <input type="text" id="hddape" name="hddape" class="form-control" >
                      </div>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4">
             </div>
              </div>
          <div class="row">
            <div class="col-12 col-sm-4 col-md-4">
              <div class="form-group">
                <label for="cbotipodoc" class="control-label">TIPO DNI:</label>
                <select name="cbotipodoc" id="cbotipodoc" class="custom-select form-control" required>
                  <option value="">--Seleccione--</option>
                    <?php foreach($this->model->DniTiposListar() as $row): ?>
                        <option value="<?php echo $row->doctipo_id; ?>"><?php echo $row->doctipo_nombre; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>

              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label for="dni" class="control-label" >N°:</label>
                    <input type="text" class="form-control" id="hdddni" name="hdddni" >
                </div>
              </div>
          </div>
          <div class="row">
          <div class="col-12 col-sm-4 col-md-4">
              <div class="form-group">
                 <label for="fe" class="control-label">Fecha Nacimiento: </label>
                  <input type="Date" class="form-control" id="textfecha" name="textfecha" >
              </div>
            </div>
            <div class="col-xs-12 col-sm-6">
              <div class="form-group">
                <label id="celular" class="control-label" >LEGAJO ANTERIOR:</label>
                  <input type="text" class="form-control" id="nroleg" name="nroleg" >
              </div>
            </div>

          <div class="col-12 col-sm-4 col-md-4">
            <div class="form-group">
              <label for="cbosexo" class="control-label" >Sexo:</label>
              <select name="cbosexo" id="cbosexo" class="custom-select form-control" >
                 <option></option>
                   <?php foreach($this->model->SexoListar() as $row):  ?>
                       <option value="<?php echo $row->sexo_id; ?>"> <?php  echo $row->sexo_nombre;?> </option>
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
                 <option value="<?php echo $row->estcivil_id; ?>"> <?php echo $row->estcivil_nombre;?> </option>
                   <?php endforeach; ?>
             </select>
            </div>
          </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
              <div class="form-group">
                <label id="celular" class="control-label" >Celular:</label>
                  <input type="text" class="form-control" id="celular" name="celular" >
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
              <div class="form-group">
                <label for="cboobrasocial" class="control-label" >Obra Social:</label>
                <select name="cboobrasocial" id="cboobrasocial" class="custom-select form-control" >
                   <option></option>
                     <?php foreach($this->model->ObraSocialListar() as $row):  ?>
                         <option value="<?php echo $row->obra_social_id; ?>"> <?php  echo $row->obra_social_nombre;?> </option>
                     <?php endforeach; ?>
                </select>
              </div>
            </div>
        </div>
        <div class="row">
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label id="direccion" class="control-label" >Calle:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" >
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="form-group">
                    <label for="cbolocalidad" class="control-label">Localidad:</label>
                    <select name="cbolocalidad" id="cbolocalidad" class="custom-select form-control" >
                      <option></option>
                        <?php foreach($this->model->LocalidadListar() as $row): ?>
                          <option value="<?php echo $row->localidad_id; ?>"> <?php echo $row->localidad_nombre;?> </option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnjubiladomodificar" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </div>
  </div>
  
</form>
