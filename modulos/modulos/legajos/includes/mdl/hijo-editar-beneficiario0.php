<form id="#" action="?c=empleado&a=HijoBenGuardar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="UpdateBeneficiarioHijo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="hidden" class="form-control" name="hijobenid" id="hijobenid">
                <input type="hidden" class="form-control" name="empbenid" id="empbenid">
                <input type="hidden" class="form-control" name="hddempnrodocto" id="hddempnrodocto">
                <input type="hidden" class="form-control" name="hddbennrodocto" id="hddbennrodocto">
                <input type="hidden" class="form-control" name="hddbeneficiarioid" id="hddbeneficiarioid">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-6">
              <div class="form-group">
                <label for="hijobenndoc" class="control-label">DNI:</label>
                <input type="text" name="hijobenndoc" id="hijobenndoc" class="form-control form-control-sm" placeholder="Ej: 22330150" required>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6">
              <div class="form-group">
                <label for="hijonbennoficio" class="control-label">Nro Oficio: </label>
                <input type="text" name="hijonbennoficio" id="hijonbennoficio" class="form-control form-control-sm" placeholder="Ej: 10/08">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-6">
              <div class="form-group">
                <label for="hijobenapellido" class="control-label">Apellido: </label>
                <input type="text" name="hijobenapellido" id="hijobenapellido" class="form-control form-control-sm" placeholder="Ej: Gonzalez" required>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6">
              <div class="form-group">
                <label for="hijobennombres" class="control-label">Nombres:</label>
                <input type="text" name="hijobennombres" id="hijobennombres" class="form-control form-control-sm" placeholder="Ej: Maria Eva" required>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <!--<button type="button" class="btn btn-danger">Dar de baja OB</button>-->
          <button type="submit" class="btn btn-primary">Actualizar datos</button>
        </div>
      </div>
    </div>
  </div>
</form>
