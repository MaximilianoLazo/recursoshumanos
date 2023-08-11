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
          <input type="hidden" class="form-control" id="hddusuarioidclave" name="hddusuarioidclave">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <!--<div class="form-group">-->
              <div class="mb-3">
                <label for="txtclavenueva" class="control-label">Contraseña Actual:</label>
                <input type="password" name="txtclavenueva" id="txtclavenueva" class="form-control form-control-sm" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <!--<div class="form-group">-->
              <div class="mb-3">
                <label for="txtclaveactual" class="control-label">Nueva Contraseña:</label>
                <input type="password" name="txtclaveactual" id="txtclaveactual" class="form-control form-control-sm" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required>
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
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <!--<div class="form-group">-->
              
                <small style="margin-top: 15px;" id="smlusuarionotificacion" class="form-text">*</small>
              
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="btnclavecambiar" class="btn btn-primary">Guardar Datos</button>
        </div>
      </div>
    </div>
  </div>
</form>