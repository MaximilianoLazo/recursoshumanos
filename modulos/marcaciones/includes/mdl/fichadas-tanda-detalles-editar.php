<form id="" action="?c=marcacion&a=FichadasTandaDetallesGuardar" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="FichadasTandaDetallesGuardar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <!--<input type="hidden" class="form-control" id="hddfictide" name="hddfictide">-->
          <input type="hidden" class="form-control" id="hddfictandaide" name="hddfictandaide">
          <input type="hidden" class="form-control" id="hddfictandadetalleltrabajoide" name="hddfictandadetalleltrabajoide">
          <input type="hidden" class="form-control" id="hddfictandadetallesecrtariaide" name="hddfictandadetallesecrtariaide">
          <input type="hidden" class="form-control" id="hddfictandadetallerelojide" name="hddfictandadetallerelojide">
          <!--<input type="hidden" class="form-control" id="hddfictide" name="hddfictide">-->
          <!--<input type="hidden" class="form-control" id="hddempnrodoctoe" name="hddempnrodoctoe">-->
          <div class="row">
            <div class="col-xs-12 col-sm-12">
              <div class="form-group">
                <label for="txtfictandadetallednieditar" class="control-label">DNI:</label>
                <input type="text" name="txtfictandadetallednieditar" id="txtfictandadetallednieditar" class="form-control form-control-sm" placeholder="" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="txtasignaciont" class="control-label">Apellido:</label>
                <div class="alert alert-info" role="alert">
                  <h6 class="text-primary lblfictandadetalleapellidoeditar" id="lblfictandadetalleapellidoeditar">-</h6>
                </div>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="TxtEmpFechaFinalizacionAdd" class="control-label">Nombres:</label>
                <div class="alert alert-info" role="alert">
                  <h6 class="text-primary lblfictandadetallenombreseditar" id="lblfictandadetallenombreseditar">-</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="txtasignaciont" class="control-label">Lugar de Trabajo:</label>
                <div class="alert alert-info" role="alert">
                  <h6 class="text-primary lblfictandadetalleltrabajoeditar" id="lblfictandadetalleltrabajoeditar">-</h6>
                </div>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6">
              <div class="form-group">
                <label for="txtasignaciont" class="control-label">Reloj:</label>
                <div class="alert alert-info" role="alert">
                  <h6 class="text-primary lblfictandadetallerelojeditar" id="lblfictandadetallerelojeditar">-</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 col-sm-12">
              <div class="form-group">
                <label for="TxtEmpFechaFinalizacionAdd" class="control-label">Secretaria:</label>
                <div class="alert alert-info" role="alert">
                  <h6 class="text-primary lblfictandadetallesecrtariaeditar" id="lblfictandadetallesecrtariaeditar">-</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" id="btnfictandadetalleguardar" class="btn btn-primary">GUARDAR DATOS</button>
        </div>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript">
</script>
