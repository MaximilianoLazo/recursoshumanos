<form id="#" action="?c=empleado&a=HijoMoPGuardar" method="post" enctype="multipart/form-data">
<div class="modal fade" id="UpdatemopHijo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <input type="hidden" class="form-control" name="hijomopid" id="hijomopid">
              <input type="hidden" class="form-control" name="empmopid" id="empmopid">
              <!--<input type="hidden" class="form-control" name="empnrodocto" id="empnrodocto">-->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijomopndoc" class="control-label">DNI:</label>
              <input type="text" name="hijomopndoc" id="hijomopndoc" class="form-control form-control-sm" placeholder="Ej: 22330150" required>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijomopapellido" class="control-label">Apellido: </label>
              <input type="text" name="hijomopapellido" id="hijomopapellido" class="form-control form-control-sm" placeholder="Ej: Gonzalez" required>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="hijomopnombres" class="control-label">Nombres:</label>
              <input type="text" name="hijomopnombres" id="hijomopnombres" class="form-control form-control-sm" placeholder="Ej: Maria Eva" required>
            </div>
          </div>
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
<script type="text/javascript">
/*
    $(document).ready(function(){
        $("#frm-hijomodificar").submit(function(){
            return $(this).validate();
        });
    })
*/
</script>
