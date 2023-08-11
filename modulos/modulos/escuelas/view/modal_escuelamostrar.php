<form id="frm-conyugeagregar" action="?c=escuela&a=GuardarE" method="post" enctype="multipart/form-data">
<div class="modal fade bd-example-modal-lg" id="dataViewEscuela" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="escuelappdl" id="escuelappdl">
        <input type="hidden" name="escuelaid" id="escuelaid">
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <table>
                <tr>
                  <td class="dato1">MOSTRAR</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-7">
            <div class="form-group">
              <label for="escuelanombre" class="control-label">Nombre: </label>
              <h4 class="modal-title" id="escuelanombre"></h4>
            </div>
          </div>
          <div class="col-xs-12 col-sm-5">
            <div class="form-group">
              <label for="escuelanro" class="control-label">Nro.:</label>
              <input type="number" name="escuelanro" id="escuelanro" class="form-control form-control-sm" placeholder="Ej: 127" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="escueladireccion" class="control-label">Direccion: </label>
              <input type="text" name="escueladireccion" id="escueladireccion" class="form-control form-control-sm" placeholder="Ej: 3 de Febrero">
            </div>
          </div>
          <div class="col-xs-12 col-sm-2">
            <div class="form-group">
              <label for="escueladirecnro" class="control-label">Nro.:</label>
              <input type="text" name="escueladirecnro" id="escueladirecnro" class="form-control form-control-sm" placeholder="Ej: 80">
            </div>
          </div>
          <div class="col-xs-12 col-sm-2">
            <div class="form-group">
              <label for="escueladirecpiso" class="control-label">Piso:</label>
              <input type="text" name="escueladirecpiso" id="escueladirecpiso" class="form-control form-control-sm" placeholder="Ej: 2">
            </div>
          </div>
          <div class="col-xs-5 col-sm-2">
            <div class="form-group">
              <label for="escuelacpostal" class="control-label">C Postal:</label>
              <input type="text" name="escuelacpostal" id="escuelacpostal" class="form-control form-control-sm" placeholder="Ej: 2840">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="escuelatelefono" class="control-label">Telefono :</label>
              <input type="text" name="escuelatelefono" id="escuelatelefono" class="form-control form-control-sm" placeholder="Ej: 03444429363">
            </div>
          </div>
          <div class="col-xs-12 col-sm-9">
            <div class="form-group">
              <label for="escuelaemail" class="control-label">Email :</label>
              <input type="email" name="escuelaemail" id="escuelaemail" class="form-control form-control-sm" placeholder="Ej: sistemas@gualeguay.gob.ar">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="escuelapais" class="control-label">Pais: </label>
              <select name="escuelapais" id="escuelapais" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
                  <?php foreach($this->model->Paises() as $row): ?>
                      <option value="<?php echo $row->pais_id; ?>"><?php echo $row->pais_nombre; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="escuelaprovincia" class="control-label">Provincia:</label>
              <select name="escuelaprovincia" id="escuelaprovincia" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="escueladepartamento" class="control-label">Departamento:</label>
              <select name="escueladepartamento" id="escueladepartamento" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <div class="form-group">
              <label for="escuelalocalidad" class="control-label">Localidad:</label>
              <select name="escuelalocalidad" id="escuelalocalidad" class="custom-select form-control" required>
                <option value="">--SELECCIONE--</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Agregar datos</button>
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
