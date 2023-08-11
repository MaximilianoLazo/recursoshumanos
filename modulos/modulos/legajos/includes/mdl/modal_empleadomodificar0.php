<form id="actualidarDatos">
<div class="modal fade" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Empleado:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
			<div id="datos_ajax"></div>
          <div class="form-group">
            <label for="empnrodocto" class="control-label">Nro. Docto:</label>
            <input type="text" class="form-control" id="empnrodocto" name="empnrodocto" disabled>
			      <input type="hidden" class="form-control" id="id" name="id">
          </div>
		  <div class="form-group">
            <label for="nombre" class="control-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="45">
          </div>
		  <div class="form-group">
            <label for="moneda" class="control-label">Moneda:</label>
            <input type="text" class="form-control" id="moneda" name="moneda" required maxlength="3">
          </div>
		  <div class="form-group">
            <label for="capital" class="control-label">Capital:</label>
            <input type="text" class="form-control" id="capital" name="capital" required maxlength="30">
          </div>
		  <div class="form-group">
            <label for="continente" class="control-label">Continente:</label>
            <input type="text" class="form-control" id="continente" name="continente" required maxlength="15">
          </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Actualizar datos</button>
      </div>
    </div>
  </div>
</div>
</form>
