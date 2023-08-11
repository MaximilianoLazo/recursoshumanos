<form id="" action="?c=marcacion&a=FichadasTandaGuardar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="FichadasTandaEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="hddfictide" name="hddfictide">
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtfichtntandae" class="control-label">Nombre de Tanda:</label>
                <input type="text" name="txtfichtntandae" id="txtfichtntandae" class="form-control form-control-sm" placeholder="Ingrese nombre de tanda" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtfictfecdesdee" class="control-label">Fecha Desde:</label>
                <input type="date" name="txtfictfecdesdee" id="txtfictfecdesdee" class="form-control form-control-sm" placeholder="" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtfictfechastae" class="control-label">Fecha Hasta: </label>
                <input type="date" name="txtfictfechastae" id="txtfictfechastae" class="form-control form-control-sm" placeholder="" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtfictfecprocesoe" class="control-label">Fecha de Proceso: </label>
                <input type="date" name="txtfictfecprocesoe" id="txtfictfecprocesoe" class="form-control form-control-sm" placeholder="" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">GUARDAR DATOS</button>
        </div>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript">
</script>
