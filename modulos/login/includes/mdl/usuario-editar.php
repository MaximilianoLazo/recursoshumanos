<form id="" action="?c=usuario&a=UsuarioGuardar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="UsuarioEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="text" class="form-control" id="hddempide" name="hddempide">
          <input type="text" class="form-control" id="hddempnrodoctoe" name="hddempnrodoctoe">
          <div class="row">
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="txtempfecbajae" class="control-label">Usuario: </label>
                <input type="text" name="txtusuario" id="txtusuario"  class="form-control form-control-sm" required />
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="txtempfecbajae" class="control-label">DNI: </label>
                <input type="text" name="txtdni" id="txtdni" class="form-control form-control-sm" required />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtapellido" class="control-label">Apellido: </label>
                <input type="text" name="txtape" id="txtape"  class="form-control form-control-sm" required />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtempfecbajae" class="control-label">Nombres: </label>
                <input type="text" name="txtnom" id="txtnom"  class="form-control form-control-sm" required />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtempfecbajae" class="control-label">Email: </label>
                <input type="email" name="txtemail" id="txtemail" class="form-control form-control-sm" required />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnempleadoguardar" class="btn btn-primary">GUARDAR DATOS</button>
        </div>
      </div>
    </div>
  </div>
</form>
