<form id="#" action="?c=empleado&a=HijoGuardar" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateHijo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <!--
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <h4 class="text-blue">Datos de Hij@</h4>
            <br>
          </div>
        </div>
      -->
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input type="hidden" class="form-control" name="id" id="id">
              <input type="hidden" class="form-control" name="empid" id="empid">
              <input type="hidden" class="form-control" name="empnrodocto" id="empnrodocto">
              <input type="hidden" class="form-control" name="bennrodocto" id="bennrodocto">
              <input type="hidden" class="form-control" name="hijoppdl" id="hijoppdl">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijondoc" class="control-label">DNI:</label>
              <input type="text" name="hijondoc" id="hijondoc" class="form-control form-control-sm" placeholder="Ej: 22330150" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijonrocuil" class="control-label">CUIL: </label>
              <input type="text" name="hijonrocuil" id="hijonrocuil" class="form-control form-control-sm" placeholder="Ej: 20-22330150-4">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijoapellido" class="control-label">Apellido: </label>
              <input type="text" name="hijoapellido" id="hijoapellido" class="form-control form-control-sm" placeholder="Ej: Gonzalez" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijonombres" class="control-label">Nombres:</label>
              <input type="text" name="hijonombres" id="hijonombres" class="form-control form-control-sm" placeholder="Ej: Jose Luis" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijosexo" class="control-label">Sexo:</label>
              <select name="hijosexo" id="hijosexo" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->Sexos() as $row): ?>
                      <option value="<?php echo $row->sexo_id; ?>"><?php echo $row->sexo_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijofecnacto" class="control-label">F. Nacimiento:</label>
              <input type="date" name="hijofecnacto" id="hijofecnacto" class="form-control form-control-sm" placeholder="Ej: 02/10/1981" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijodireccion" class="control-label">Direccion: </label>
              <input type="text" name="hijodireccion" id="hijodireccion" class="form-control form-control-sm" placeholder="Ej: 3 de Febrero">
            </div>
          </div>
          <div class="col-xs-12 col-sm-2">
            <div class="form-group">
              <label for="hijodirecnro" class="control-label">Nro.:</label>
              <input type="text" name="hijodirecnro" id="hijodirecnro" class="form-control form-control-sm" placeholder="Ej: 80">
            </div>
          </div>
          <div class="col-xs-12 col-sm-2">
            <div class="form-group">
              <label for="hijodirecpiso" class="control-label">Piso:</label>
              <input type="text" name="hijodirecpiso" id="hijodirecpiso" class="form-control form-control-sm" placeholder="Ej: 2">
            </div>
          </div>
          <div class="col-xs-5 col-sm-2">
            <div class="form-group">
              <label for="hijocodpostal" class="control-label">C. P.:</label>
              <input type="text" name="hijocodpostal" id="hijocodpostal" class="form-control form-control-sm" placeholder="Ej. 2840">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijopais" class="control-label">Pais: </label>
              <select name="hijopais" id="hijopais" class="custom-select form-control" required>
                <option value="">--Seleccione--</option>
                  <?php foreach($this->model->Paises() as $row): ?>
                      <option value="<?php echo $row->pais_id; ?>"><?php echo $row->pais_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijoprovincia" class="control-label">Provincia:</label>
              <select name="hijoprovincia" id="hijoprovincia" class="custom-select form-control" required>
                <option></option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijodepartamento" class="control-label">Departamento:</label>
              <select name="hijodepartamento" id="hijodepartamento" class="custom-select form-control" required>
                <option></option>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijolocalidad" class="control-label">Localidad:</label>
              <select name="hijolocalidad" id="hijolocalidad" class="custom-select form-control" required>
                <option></option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <!--<label for="hijodisc" class="control-label">Discapacidad?</label>-->
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" name="hijodisc" id="hijodisc" value="1" class="custom-control-input">
                <label class="custom-control-label" for="hijodisc"><em>&nbsp;Discapacidad?</em></label>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <!--<label for="hijodisc" class="control-label">Discapacidad?</label>-->
              <div class="custom-control custom-checkbox mb-5">
                <input type="checkbox" name="prenatalb" id="prenatalb" value="1" class="custom-control-input">
                <label class="custom-control-label" for="prenatalb"><em>&nbsp;Finalizar Pre-Natal?</em></label>
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
<script type="text/javascript">
/*
    $(document).ready(function(){
        $("#frm-hijomodificar").submit(function(){
            return $(this).validate();
        });
    })
*/
</script>
