<form id="frm-relojeditar" action="?c=parametro&a=GuardarF" method="post" enctype="multipart/form-data">
<div class="modal fade" id="dataUpdateParametro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
			<div id="datos_ajax"></div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
            <div class="col-md-12">
            <div class="form-group">
              <label for="cbonovedadtipo" class="control-label">Seleccione Tipo de Novedad:</label>
              <select name="cbonovedadtipo" style="font-size: 12px;" id="cbonovedadtipo" class="custom-select form-control" required>
                <option value="">-- SELECCIONE --</option>
                <?php foreach($this->model->ListarNovedades() as $row): ?>
                <option value="<?php echo $row->liqcod_id; ?>"><?php echo $row->nombre; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            <div class="form-group">
              <label for="feriadofecha" class="control-label">Nombre Parámetro:</label>
              <input type="text" class="form-control form-control-sm" id="paranombre" name="paranombre">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              
              <label for="desde" class="control-label">Desde: </label>
              <input type="text" name="desde" id="desde" class="form-control form-control-sm" >
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hasta" class="control-label">Hasta:</label>
              <input type="text" name="hasta" id="hasta" class="form-control form-control-sm"  >
            </div>
          </div>

          <div class="form-group">
							<div class="row">
								
                  <div class="col-md-6 col-sm-12">
                      <div class="custom-control custom-radio mb-5">
                          <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" onchange="javascript:mostrar()" >
                          <label class="custom-control-label" for="customRadio1">Importe</label>
                          <input type="text" class="form-control form-control-sm" id="monto" name="monto">
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                    <div class="custom-control custom-radio mb-5">
                        <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input" onchange="javascript:mostrar()">
                        <label class="custom-control-label" for="customRadio2">Porcentaje</label>
                        <input type="text" class="form-control form-control-sm" id="porcentaje" name="porcentaje">
                    </div>
                </div>
							</div>
						</div>
           </div>
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
let chec = document.getElementById("customRadio1");

window.addEventListener("load", () => {
  chec.checked=true;
  document.getElementById("porcentaje").style.display='none';

})

	      function mostrar() {
					elemonto=document.getElementById("customRadio1");
          element1 = document.getElementById("monto");
					element2= document.getElementById("porcentaje");
				
          if (elemonto.checked) {

              element1.style.display='block';
							element2.style.display='none';
              element2="";
              						
          }
          else {
						element1.style.display='none';
						element2.style.display='block';
            element1="";
			    }
      }
  </script>
</form>
	 


