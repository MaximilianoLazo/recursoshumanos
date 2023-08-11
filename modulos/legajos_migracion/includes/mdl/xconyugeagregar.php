<form id="frm-conyugeagregar" action="?c=empleado&a=GuardarC" method="post" enctype="multipart/form-data">
<div class="modal fade bd-example-modal-lg" id="dataAddConyuge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
            <div class="form-group">
              <label for="conyugetdoc" class="control-label">T DOC: </label>
              <select name="conyugetdoc" id="conyugetdoc" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->TiposDocto() as $row): ?>
                      <option value="<?php echo $row->doctipo_id; ?>"><?php echo $row->doctipo_abreviacion; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-5">
            <div class="form-group">
              <label for="conyugendoc" class="control-label">Nro. DOC:</label>
              <input type="text" name="conyugendoc" id="conyugendoc" class="form-control form-control-sm" placeholder="Ej: 22330150" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="conyugeapellido" class="control-label">Apellido: </label>
              <input type="text" name="conyugeapellido" id="conyugeapellido" class="form-control form-control-sm" placeholder="Ej: Gonzalez" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-5">
            <div class="form-group">
              <label for="conyugenombres" class="control-label">Nombres:</label>
              <input type="text" name="conyugenombres" id="conyugenombres" class="form-control form-control-sm" placeholder="Ej: Jose Luis" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group">
              <label for="conyugenrocuil" class="control-label">CUIL: </label>
              <input type="text" name="conyugenrocuil" id="conyugenrocuil" class="form-control form-control-sm" placeholder="Ej: 20-22330150-4">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="conyugesexo" class="control-label">Sexo:</label>
              <select name="conyugesexo" id="conyugesexo" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->Sexos() as $row): ?>
                      <option value="<?php echo $row->sexo_id; ?>"><?php echo $row->sexo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group">
              <label for="conyugefecnacto" class="control-label">F. Nacimiento:</label>
              <input type="date" name="conyugefecnacto" id="conyugefecnacto" class="form-control form-control-sm" placeholder="Ej: 02/10/1981" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="conyugedireccion" class="control-label">Direccion: </label>
              <input type="text" name="conyugedireccion" id="conyugedireccion" class="form-control form-control-sm" placeholder="Ej: 3 de Febrero">
            </div>
          </div>
          <div class="col-xs-12 col-sm-2">
            <div class="form-group">
              <label for="conyugedirecnro" class="control-label">Nro.:</label>
              <input type="text" name="conyugedirecnro" id="conyugedirecnro" class="form-control form-control-sm" placeholder="Ej: 80">
            </div>
          </div>
          <div class="col-xs-12 col-sm-2">
            <div class="form-group">
              <label for="conyugedirecpiso" class="control-label">Piso:</label>
              <input type="text" name="conyugedirecpiso" id="conyugedirecpiso" class="form-control form-control-sm" placeholder="Ej: 2">
            </div>
          </div>
          <div class="col-xs-5 col-sm-2">
            <div class="form-group">
              <label for="conyugecodpostal" class="control-label">C Postal:</label>
              <input type="text" name="conyugecodpostal" id="conyugecodpostal" class="form-control form-control-sm" placeholder="Ej: 2840">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="conyugecelular" class="control-label">Celular :</label>
              <input type="text" name="conyugecelular" id="conyugecelular" class="form-control form-control-sm" placeholder="Ej: +543444445441">
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="conyugetelefono" class="control-label">Telefono :</label>
              <input type="text" name="conyugetelefono" id="conyugetelefono" class="form-control form-control-sm" placeholder="Ej: 03444429363">
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="conyugeemail" class="control-label">Email :</label>
              <input type="email" name="conyugeemail" id="conyugeemail" class="form-control form-control-sm" placeholder="Ej: sistemas@gualeguay.gob.ar">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="conyugepais" class="control-label">Pais: </label>
              <select name="conyugepais" id="conyugepais" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->Paises() as $row): ?>
                      <option value="<?php echo $row->pais_id; ?>"><?php echo $row->pais_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="conyugeprovincia" class="control-label">Provincia:</label>
              <select name="conyugeprovincia" id="conyugeprovincia" class="custom-select form-control" required>
                <option></option>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="conyugedepartamento" class="control-label">Departamento:</label>
              <select name="conyugedepartamento" id="conyugedepartamento" class="custom-select form-control" required>
                <option></option>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="conyugelocalidad" class="control-label">Localidad:</label>
              <select name="conyugelocalidad" id="conyugelocalidad" class="custom-select form-control" required>
                <option></option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input type="hidden" class="form-control" name="empid" id="empid">
              <input type="hidden" class="form-control" name="empnrodocto" id="empnrodocto">
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
<script type="text/javascript">
/*
    $(document).ready(function(){
        $("#frm-conyugeagregar").submit(function(){
            return $(this).validate();
        });
    })
*/
</script>
