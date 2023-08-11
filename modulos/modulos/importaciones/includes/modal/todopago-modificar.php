<form id="frm-todopago-modificar" action="?c=todopago&a=ModificarCompra" method="post" enctype="multipart/form-data">
  <div class="modal fade" id="dataUpdateTodoPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Estas seguro?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="modal-body">
          <input type="hidden" id="numconcepto" name="numconcepto">
	         <p class="lead text-muted text-center" style="display: block;margin:10px">Esta acción pasara el nro de concepto a estado 2. Deseas continuar?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-lg btn-primary">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</form>
<script>
/*
    $(document).ready(function(){
        $("#frm-relojdeshabilitar").submit(function(){
            return $(this).validate();
        });
    })
*/
</script>
