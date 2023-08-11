<?php
  //require_once '../../../../database/Conexion.php';
  //require_once '../../model/empleado.php';

  //$constancias = new Empleado();
  $id =  $_REQUEST['id'];
?>
<form id="frm-hijomodificar" action="#" method="post" enctype="multipart/form-data">
<div class="modal fade bd-example-modal-lg" id="dataConstanciaHijo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <h4 class="text-blue">Datos de Hij@s Escolares</h4>
            </div>
          </div>
          <div class="col-xs-6 col-sm-6">
            <div class="form-group">
              <div align="right">
                <button type="button" class="btn btn-danger" id="BtnListarContratos">Imprimir Constancias</button>
              </div>
            </div>

          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <table class="hijosconstancia">
                <thead>
                  <tr>
                    <th scope="col">Nro. Docto</th>
                    <th scope="col">Apellido y Nombres</th>
                    <th scope="col">Escuela</th>
                    <th scope="col" width="5%">
                      <div class="custom-control custom-checkbox mb-5">
                        <input type="checkbox" class="custom-control-input check-all" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1"></label>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  foreach($this->model->ObtenerHijosEscolares2($id) as $row){
                ?>
                  <tr>
                       <td><?php echo $row->leghijo_nrodocto; ?></td>
                       <td><?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres; ?></td>
                       <td><?php echo $row->escuela_nombre; ?></td>
                       <td>

                         <div class="custom-control custom-checkbox mb-5">
                           <input type="checkbox" class="custom-control-input check-cont" name="checkbox[]" value="<?php echo $row->leghijo_nrodocto; ?>" id="checkbox[<?php echo $row->leghijo_nrodocto; ?>]" checked="checked">
                           <label class="custom-control-label" for="checkbox[<?php echo $row->leghijo_nrodocto; ?>]"></label>
                         </div>

                       </td>
                  </tr>
                <?php
                }
                ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!--
        <div class="row">
          <div class="col-xs-12 col-sm-5">
            <div class="form-group">
              <label for="hijoapellido" class="control-label">Apellido: </label>
              <input type="text" name="hijoapellido" id="hijoapellido" class="form-control form-control-sm" placeholder="Ej: Gonzalez" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-7">
            <div class="form-group">
              <label for="hijonombres" class="control-label">Nombres:</label>
              <input type="text" name="hijonombres" id="hijonombres" class="form-control form-control-sm" placeholder="Ej: Jose Luis" required>
            </div>
          </div>
        </div>
        -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <!--<button type="submit" class="btn btn-primary">Actualizar datos</button>-->
      </div>
    </div>
  </div>
</div>
</form>
<script>

</script>
