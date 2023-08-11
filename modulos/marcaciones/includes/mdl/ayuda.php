<form id="frm-estudiodeshabilitar" action="?c=empleado&a=DeshabilitarH" method="post" enctype="multipart/form-data">
<div class="modal fade" id="ayuda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Estas seguro?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hijoid" name="hijoid">
        <input type="hidden" id="empid" name="empid">
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <table id="tablapruu" border="1" class="table table-striped table-hover table-fixed">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Hora</th>
                  <th>Reloj</th>
                  <th>Direccion</th>
                  <th>Fuente</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody id="ajaa">
                <tr id="fofofu">
                  <td id="dni" data-id_dni="1" data-title="Fecha:">36583053</td>
                  <td data-title="Hora:"></td>
                  <td data-title="Reloj:"></td>
                  <td data-title="Direccion:"></td>
                  <td data-title="Fuente:"></td>
                  <td data-title="Estado:"></td>
                </tr>
                <tr id="fofofu">
                  <td id="dni" data-id_dni="2" data-title="Fecha:">29170580</td>
                  <td id="dni" data-id_dni="2" data-title="Hora:">1</td>
                  <td id="dni" data-id_dni="2" data-title="Reloj:">2</td>
                  <td id="dni" data-id_dni="2" data-title="Direccion:">3</td>
                  <td id="dni" data-id_dni="2" data-title="Fuente:">4</td>
                  <td id="dni" data-id_dni="2" data-title="Estado:"></td>
                </tr>
                <tr id="fofofu">
                  <td id="dni" data-id_dni="3" data-title="Fecha:">33666999</td>
                  <td data-title="Hora:"></td>
                  <td data-title="Reloj:"></td>
                  <td data-title="Direccion:"></td>
                  <td data-title="Fuente:"></td>
                  <td data-title="Estado:"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-lg btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>
</form>
<script>
/*
    $(document).ready(function(){
        $("#frm-relojdeshabilitar").submit(function(){
            return $(this).validate();
        });
    })
*/
</script>
