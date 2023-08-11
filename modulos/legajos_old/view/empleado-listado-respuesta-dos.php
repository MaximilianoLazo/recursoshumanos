<?php

error_reporting(0);
session_start();
if(!isset($_SESSION['usuario_id'])){
  header('Location: ../login/index.php');
}

$secretariaid = $_POST["CboSecretaria"];
$ltrabajoid = $_POST["CboLTrabajo"];
$srevista = $_POST["CboSRevista"];

?>
<div class="form-group">
  <div align="right">
    <button type="button" class="btn btn-info" id="btnimpempleados">Imprimir Listado</button>
  </div>
</div>
<?php
if($srevista == "T"){
  if($ltrabajoid == "" OR $ltrabajoid == "T"){
    $empledosdatos = $this->model->EmpleadosXSecretiriaObtenerDos($secretariaid, $srevista);
  }else{
    $empledosdatos = $this->model->EmpleadosXLTrabajoObtenerDos($ltrabajoid, $srevista);
  }
}else{
  if($ltrabajoid == "" OR $ltrabajoid == "T"){
    $empledosdatos = $this->model->EmpleadosXSecretiriaObtener($secretariaid, $srevista);
  }else{
    $empledosdatos = $this->model->EmpleadosXLTrabajoObtener($ltrabajoid, $srevista);
  }
}


$empledosdatosc = count($empledosdatos);

//---inicio ordena array ----
$col = 'emptrabajonombre';
$col2  = 'empapellido';
$col3  = 'empnombres';

$sort = array();
$sort2 = array();
$sort3 = array();

foreach ($empledosdatos as $i => $obj) {
  $sort[$i] = $obj->{$col};
  $sort2[$i] = $obj->{$col2};
  $sort3[$i] = $obj->{$col3};
}


array_multisort($sort2, SORT_ASC, $sort3, SORT_ASC, $sort, SORT_ASC, $empledosdatos);
//----fin ordena array -----
//---elimina null o vacios ----
foreach($empledosdatos as $clave=>$valor){
if(empty($valor)) unset($empledosdatos[$clave]);
}
$empledosdatos = array_merge($empledosdatos);

//var_dump($empledosdatos);

?>


<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label class="control-label"><?php echo "Cantidad de Empleados: ".$empledosdatosc; ?></label>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div id="no-more-tables">
      <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table width="100%" border="1" class="table table-striped table-hover table-fixed">
          <thead>
            <tr>
              <th>DNI</th>
              <th>APELLIDO Y NOMBRES</th>
              <th>SITUACION DE REVISTA</th>
              <th>LUGAR DE TRABAJO</th>
              <th>TAREA</th>
              <th>FEC INGRESO</th>
            </tr>
          </thead>
          <tbody>
            <?php


              //foreach($empledosdatos as $key => $value):
              foreach($empledosdatos as $key => $value){

                $trabajodatos = $this->model->ObtenerLugarDeTrabajo($value->emptrabrajo);
                $secretariadatos = $this->model->ObtenerSecretaria($value->empsecretaria);

            ?>
            <tr>
              <td data-title="no name:"><?php echo $value->empdni; ?></td>
              <td data-title="no name:">
                <?php echo $value->empapellido.", <br>".$value->empnombres; ?>
              </td>
              <td data-title="no name:"><?php echo $value->emptlegajo; ?></td>
              <td data-title="no name:"><?php echo $trabajodatos->trabajo_nombre; ?></td>
              <td data-title="no name:"><?php echo $value->emptarea; ?></td>
              <td data-title="no name:"><?php echo $value->empfecingreso; ?></td>
            </tr>
          <?php }//endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
  jQuery(document).ready(function(){

    jQuery("#btnimpempleados").click(function(){
      //--------Obtenemos el valor del input

      var params = {
        //"NroDnis" : nrodnis,
        //"ContratosC" : '<?php //echo $contratosc;?>',
        "Secretaria" : '<?php echo $secretariaid;?>',
        "LTrabajo" : '<?php echo $ltrabajoid; ?>',
        "SRevista": '<?php echo $srevista; ?>',
      };
      //--------llamada al fichero PHP con AJAX
      $.ajax({
        cache: false,
        type: 'POST',
        //dataType:"html",
        //url: 'includes/pdf/contrato-listado.php',
        url:  '?c=empleado&a=EmpleadoListadoPDF',

        //contentType: false,
        //processData: false,
        data: params,
        //xhrFields is what did the trick to read the blob to pdf
        xhrFields:{
          responseType: 'blob'
        },
        success: function (response, status, xhr){
          var filename = "";
          var disposition = xhr.getResponseHeader('Content-Disposition');

          if(disposition){
            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
            var matches = filenameRegex.exec(disposition);
            if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
          }
          var linkelem = document.createElement('a');
          try{
            var blob = new Blob([response], { type: 'application/octet-stream' });

            if(typeof window.navigator.msSaveBlob !== 'undefined'){
              //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were creaThese URLs will no longer resolve as the data backing the URL has been freed."
              window.navigator.msSaveBlob(blob, filename);
            }else{
              var URL = window.URL || window.webkitURL;
              var downloadUrl = URL.createObjectURL(blob);

              if (filename){
                // use HTML5 a[download] attribute to specify filename
                var a = document.createElement("a");

                // safari doesn't support this yet
                if(typeof a.download === 'undefined'){
                  window.location = downloadUrl;
                }else{
                  a.href = downloadUrl;
                  a.download = filename;
                  document.body.appendChild(a);
                  a.target = "_blank";
                  a.click();
                }
              }else{
                window.location = downloadUrl;
              }
            }

          }catch(ex){
            console.log(ex);
          }
        }
      });
    });
  });
  //var checked = false;

  /*$('.check-all').on('click',function(){

    if(checked == false){
      $('.check-cont').prop('checked', true);
      checked = true;
    }else{
      $('.check-cont').prop('checked', false);
      checked = false;
    }
  });*/
</script>
