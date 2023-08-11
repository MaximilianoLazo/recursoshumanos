<?php
  set_time_limit(1800);
  error_reporting(0);
  session_start();
  if(!isset($_SESSION['usuario_id'])){
    echo '<meta http-equiv="refresh" content="0;URL=../login/index.php">';
  }
  //----sona horario y formato de fechas--------
  date_default_timezone_set("America/Buenos_Aires");
  //setlocale(LC_ALL,"es_ES");
  setlocale(LC_ALL, 'es_RA.UTF8');
  //setlocale(LC_TIME, "es_RA.UTF-8");
  setlocale(LC_TIME, 'es_RA.utf-8','spanish');
  //setlocale('es_ES.UTF-8'); // I'm french !
  $cboleindumentaria = $_POST["CboLEIndumentaria"];
  //----- calculo para rango de fecahs ----
  /*$date_start = new DateTime($fechai);
  $date_end = new DateTime("$fechaf 23:59:59");

  $interval = '+1 days';
  $date_interval = DateInterval::createFromDateString($interval);
  $period = new DatePeriod($date_start, $date_interval, $date_end);*/
  $fechai = "2020-01-01";
  $fechaf = "2020-06-30";
  $indumentariaentdatos = $this->model->IndumentariasEntregasListarXFecha($fechai, $fechaf);

?>
  <div class="row">
    <div class="col-md-2">
      <div class="form-group">
        <label for="txtindumentarialefeciniciofil" style="font-size: 12px;">Fecha Inicio :</label>
        <input type="date"
               style="font-size: 12px;"
               name="txtindumentarialefeciniciofil"
               id="txtindumentarialefeciniciofil"
               value="<?php echo $fecha_inicio; ?>"
               class="form-control"
               required
        />
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="txtindumentarialefecfinalfil" style="font-size: 12px;">Fecha Final :</label>
        <input type="date"
               style="font-size: 12px;"
               name="txtindumentarialefecfinalfil"
               id="txtindumentarialefecfinalfil"
               value="<?php echo $fecha_inicio; ?>"
               class="form-control"
               required
        />
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
      <label for="cboindumentarialesecretariafil" style="font-size: 12px;">Secretaria :</label>
      <select name="cboindumentarialesecretariafil"
              style="font-size: 12px;"
              id="cboindumentarialesecretariafil"
              class="custom-select form-control"
              required>
        <option value="0">--Todas--</option>
        <?php foreach($this->model->SecretariasListar() as $row): ?>
        <option value="<?php echo $row->secretaria_id; ?>"><?php echo $row->secretaria_nombre; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
      <label for="cboindumentarialelugartrabajofil" style="font-size: 12px;">Lugar de Trabajo :</label>
      <select name="cboindumentarialelugartrabajofil"
              style="font-size: 12px;"
              id="cboindumentarialelugartrabajofil"
              class="custom-select form-control" required>
        <option value="0">--Todas--</option>
        <?php foreach($this->model->LugaresTrabajoListar() as $row): ?>
        <option value="<?php echo $row->trabajo_id; ?>"><?php echo $row->trabajo_nombre; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="btnindumentarialefil" style="font-size: 12px;"> </label><br>
        <button  type="button"
                 style="width: 100%;"
                 name="btnindumentarialefil"
                 class="btn btn-primary"
                 id="btnindumentarialefil">
          <i class="fa fa-filter fa-lg" aria-hidden="true"></i>
          &nbsp;Filtrar
        </button>
    </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <div class="clearfix">
        <div align="right">
          <button  type="button"
                   name="btnindumentarialefil"
                   class="btn btn-success"
                   id="btnindumentarialefil">
            <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i>
            &nbsp;EXCEL
          </button>
          <button  type="button"
                   name="btnindumentarialefil"
                   class="btn btn-danger"
                   id="btnindumentarialefil">
            <i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i>
            &nbsp;PDF
          </button>
        </div>
      </div>
    </div>
  </div>
  <div id="tblcontenidoentregas">
    <div class="row">
      <table id="tblindumentarialeemp" class="data-table table-bordered stripe hover nowrap">
        <thead>
          <tr>
            <th width="">FECHA</th>
            <th width="">DNI</th>
            <th width="">APELLIDO Y NOMBRES</th>
            <th width="">ORDEN</th>
            <th width="">CANT.</th>
            <th width="">INDUMENTARIA</th>
            <th class="dt-center" width="">TALLE</th>
            <th width="">COLOR</th>
            <th width="">OBSERVACION</th>
            <th width="">LUGAR DE TRABAJO</th>
            <th width="">SECRETARIA</th>
          </tr>
        </thead>
        <tbody>
          <?php
           foreach($indumentariaentdatos as $row):
             $indumentaria_fec = new DateTime($row->indumentaria_entrega_fecha);
             $indumentaria_fec_pantalla = $indumentaria_fec->format('d/m/Y');
          ?>
          <tr>
            <td class="dt-right"><?php echo $indumentaria_fec_pantalla ?></td>
            <td class="dt-right"><?php echo $row->legempleado_nrodocto; ?></td>
            <td><?php echo $row->legempleado_apellido.", ".$row->legempleado_nombres; ?></td>
            <td class="dt-right"><?php echo $row->indumentaria_orden_id; ?></td>
            <td class="dt-right"><?php echo $row->indumentaria_entrega_cantidad; ?></td>
            <td><?php echo $row->indumentaria_nombre; ?></td>
            <td class="dt-center"><?php echo $row->indumentaria_talle_nombre; ?></td>
            <td><?php echo $row->indumentaria_color_nombre; ?></td>
            <td><?php echo $row->indumentaria_entrega_observacion; ?></td>
            <td><?php echo $row->trabajo_nombre; ?></td>
            <td><?php echo $row->secretaria_nombre; ?></td>
          </tr>
        <?php endforeach;?>
        </tbody>
      </table>
    </div>
  </div>
  <script>

    $('document').ready(function(){
      $('.data-table').DataTable({
        scrollCollapse: true,
        autoWidth: false,
        /*rowReorder: {
              selector: 'td:nth-child(1)'
        },*/
        responsive: true,
        /*responsive: {
           details: {
               display: $.fn.dataTable.Responsive.display.childRowImmediate,
               type: ''
           }
        },*/
        paging: false,
        searching: false,
        info: false,
        /*columnDefs: [{
          targets: "datatable-nosort",
          orderable: false,
        }],*/
        columnDefs: [{
          className: "dt-right",
          className: "dt-center",
        }],
        columnDefs: [{
          targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
          orderable: false,
          className: "FontSize",
        }],

        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
        "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
        },
        "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
        },
      });
    });
    jQuery(document).ready(function(){
      //--- resultado en vivo de marcaciones ---------
			jQuery("#btnindumentarialefil").click(function(){
				//--------Obtenemos el valor del input
				var indumentarialefecini = jQuery("#txtindumentarialefeciniciofil").val();
        var indumentarialefecfin = jQuery("#txtindumentarialefecfinalfil").val();
        var indumentarialesec = jQuery("#cboindumentarialesecretariafil").val();
        var indumentarialeltrabajo = jQuery("#cboindumentarialelugartrabajofil").val();
				var params = {
					"IndumentariaLEFecIni" : indumentarialefecini,
          "IndumentariaLEFecFin" : indumentarialefecfin,
          "IndumentariaLESec" : indumentarialesec,
          "IndumentariaLELTrabajo" : indumentarialeltrabajo
				};
				//--------llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
          url:   '?c=indumentaria&a=IndumentariaEntregadaListadoFechasSecLTrabajo',
					dataType: 'html',
					type:  'post',
					beforeSend: function () {
						//mostramos gif "cargando"
						//jQuery('#loading_spinner').show();
						//antes de enviar la petición al fichero PHP, mostramos mensaje
						jQuery("#tblcontenidoentregas").html("Déjame pensar un poco...");
					},
					success:  function (response) {
						//escondemos gif
						//jQuery('#loading_spinner').hide();
						//mostramos salida del PHP
						jQuery("#tblcontenidoentregas").html(response);
					}
				});
			});








      jQuery("#btnfichadasfechaspdf").click(function(){
        //--------Obtenemos el valor del input
        var params = {
          "NroDni" : '<?php echo $nrodocto; ?>',
          "FechaI" : '<?php echo $fechai; ?>',
          "FechaF" : '<?php echo $fechaf; ?>',
        };
        //--------llamada al fichero PHP con AJAX
        $.ajax({
          cache: false,
          type: 'POST',
          //dataType:"html",
          url: "?c=marcacion&a=FichadasFechasPDF",
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
  </script>

  <style>
    .FontSize{
      font-size: 12px !important;
    }
    /*#tblindumentarialeemp td:nth-child(3),
    #tblindumentarialeemp th:nth-child(3){
      text-align : center;
      font-weight: bold;
    }*/

    #tblindumentarialeemp th{
      font-weight: bold;
    }
  </style>
