<form id="frm-conyugeagregar" action="?c=empleado&a=GuardarE" method="post" enctype="multipart/form-data">
<div class="modal fade bd-example-modal-lg" id="dataTableViewImputacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="imputacioniddos" name="imputacioniddos">
        <input type="hidden" id="imputacioncodigowdos" name="imputacioncodigowdos">
        <input type="hidden" id="imputacionnombredos" name="imputacionnombredos">
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <h5 class="text-primary">C. Costo</h5>
              <strong><h6 class="text-secondary" id="lblccosto"></h6></strong>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <h5 class="text-primary">Imputación</h5>
              <strong><h6 class="text-secondary" id="lblimputacion"></h6></strong>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <h5 class="text-primary">Presupuesto</h5>
              <strong><h4 class="text-info text-center" id="lblcupos"></h4></strong>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <h5 class="text-primary">Ocupados</h5>
              <strong><h4 class="text-info text-center" id="lblocupados"></h4></strong>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <h5 class="text-primary">Disponibles</h5>
              <strong><h4 class="text-info text-center" id="lbldisponibles"></h4></strong>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group has-search">
              <span class="fa fa-search form-control-feedback"></span>
              <input type="text" class="form-control" name="search" id="search" placeholder="Buscar">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <div align="right">
                <button type="button" class="btn btn-success">CSV</button>
                <button type="button" class="btn btn-danger">PDF</button>
              </div>
            </div>
          </div>
        </div>
        <div id="tabladato">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success">CSV</button>
        <button type="button" class="btn btn-danger" id="btnimpimputacionesxempleado">PDF</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</form>
<script type="text/javascript">

</script>
