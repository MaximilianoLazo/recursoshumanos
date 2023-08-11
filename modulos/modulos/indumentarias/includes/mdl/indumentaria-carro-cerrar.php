<form id="#" action="?c=indumentaria&a=IndumentariaEntregaGuardar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="IndumentariaCarroCerrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <!--
          <input type="hidden" class="form-control" id="hddempide" name="hddempide">
          <input type="hidden" class="form-control" id="hddempnrodoctoe" name="hddempnrodoctoe">
          <input type="hidden" class="form-control" id="hddindentregaide" name="hddindentregaide">
        -->
          <input type="hidden" class="form-control" id="hddindordenide" name="hddindordenide">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <p class="lead text-muted text-left" style="display: block;">
                  Esta acción cerrara la orden de indumentaria. Deseas continuar?
                </p>
                <div class="custom-control custom-checkbox mb-5">
                  <input type="checkbox" class="custom-control-input" name="ckecindentrega" id="ckecindentrega" value="1">
                  <label class="custom-control-label" for="ckecindentrega">Entregar Indumentaria ?</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" id="#" class="btn btn-success">CERRAR Orden</button>
        </div>
      </div>
    </div>
  </div>
</form>
<style media="screen">

/*input:invalid {
    border-color: #ccc;
}

input,
input:valid {
    border-color: #ccc;
}*/
</style>
