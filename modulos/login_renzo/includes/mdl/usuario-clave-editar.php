<form id="" action="?c=usuario&a=UsuarioGuardar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="UsrEditarClave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">Cambiar Contraseña</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="hddusuarioid" name="hddusuarioid" value="<?php echo $_SESSION['usuario_id']; ?>">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <!--<div class="form-group">-->
              <div class="mb-3">
                <label for="txtclavenueva" class="control-label">Nueva Contraseña:</label>
                <input type="password" name="txtclavenueva" id="txtclavenueva" class="form-control form-control-sm" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <!--<div class="form-group">-->
              <div class="mb-3">
                <label for="txtclavenuevarep" class="control-label">Repetir Nueva Contraseña:</label>
                <input type="password" name="txtclavenuevarep" id="txtclavenuevarep" class="form-control form-control-sm" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" id="" class="btn btn-primary">Guardar Datos</button>
        </div>
      </div>
    </div>
  </div>
</form>
<script src="includes/js/usuario-clave.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    alert("Hola");
    $('#txtclavenueva').keyup(function() {
      alert("Holasolo");
    });

    /*$('#txtclavenueva, #txtclavenuevarep').on('keyup', function() {
      alert("HOLA");

    });*/

  });

  /*jQuery(document).ready(function() {
    jQuery('#txtclavenueva, #txtclavenuevarep').on('keyup', function() {
      alert("HOLA");
    });
  });*/
</script>