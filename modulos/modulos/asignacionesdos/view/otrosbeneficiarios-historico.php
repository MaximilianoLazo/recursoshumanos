<?php

  error_reporting(0);
 	session_start();
	if(!isset($_SESSION['usuario_id'])){
		header('Location: ../login/index.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
	<?php include('../../includes/head.php'); ?>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" type="text/css" href="../../src/plugins/datatables/media/css/responsive.dataTables.css">
</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!-- ventanas modal -->
	<!--<?php //include("modal_lugardetrabajomodificar.php");?>-->
  <!--<?php //include("modal_lugardetrabajoeliminar.php");?>-->
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Otros Beneficiarios</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page">Otros Benficiarios</li>
								</ol>
							</nav>
						</div>
						<div class="col-md-6 col-sm-12 text-right">
							<div class="dropdown">
								<a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									January 2018
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="#">Export List</a>
									<a class="dropdown-item" href="#">Policies</a>
									<a class="dropdown-item" href="#">View Assets</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Otros Beneficiarios - HISTORICO</h5>
						</div>
					</div>
          <div class="row">
						<div class="col-md-12">
							<div class="form-group">
                <?php
                $periodosasigotro = $this->model->ObtenerPeriodoAsigOtro();

                ?>
							</div>
						</div>
					</div>
          <?php
            foreach($periodosasigotro as $periodoi):
            $periodoid = $periodoi->periodosasigot;

          ?>

					<div class="row">
            <label><?php echo $periodoid; ?></label>
						<table class="data-table table-bordered stripe hover nowrap">
							<thead>
								<tr>
									<th style="color:#000000;font-size:10px;">Empleado</th>
									<th style="color:#000000;font-size:10px;">DNI</th>
                  <th style="color:#000000;font-size:10px;">Beneficiario</th>
									<th style="color:#000000;font-size:10px;">DNI / Oficio</th>
                  <th style="color:#000000;font-size:10px;">Pre-Natal</th>
                  <th style="color:#000000;font-size:10px;">H Menor</th>
                  <th style="color:#000000;font-size:10px;">Prescolar</th>
                  <th style="color:#000000;font-size:10px;">Esc Prim</th>
                  <th style="color:#000000;font-size:10px;">Esc Med & Sup</th>
                  <th style="color:#000000;font-size:10px;">DISC</th>
                  <th style="color:#000000;font-size:10px;">Esc DISC</th>
                  <th style="color:#000000;font-size:10px;">Total Asig</th>
                  <th style="color:#000000;font-size:10px;">Fam Num</th>
                  <th style="color:#000000;font-size:10px;">Importe</th>
                  <th style="color:#000000;font-size:10px;">Reajuste</th>
                  <th style="color:#000000;font-size:10px;">Total</th>


								</tr>
							</thead>
							<tbody>
							 <?php

                foreach($this->model->ListarOtrosBeniciariosHistorico($periodoid) as $row):
                $empleadonrodocto = $row->empleado;
                $beneficiarionrodocto = $row->beneficiario;
                $datoshistoricosob = $this->model->DatosOtrosBeneficiariosHistorico($empleadonrodocto,$beneficiarionrodocto,$periodoid);
                //--- tipos de asignaciones ---
                $asignaciontipo = 1;
                $obprenatalc = $this->model->DatosAsignacionTipo($asignaciontipo,$empleadonrodocto,$beneficiarionrodocto,$periodoid);
                $asignaciontipo = 2;
                $obhijomenorc = $this->model->DatosAsignacionTipo($asignaciontipo,$empleadonrodocto,$beneficiarionrodocto,$periodoid);
                $asignaciontipo = 3;
                $obhijodiscc = $this->model->DatosAsignacionTipo($asignaciontipo,$empleadonrodocto,$beneficiarionrodocto,$periodoid);
                $asignaciontipo = 4;
                $obhijopreescolarc = $this->model->DatosAsignacionTipo($asignaciontipo,$empleadonrodocto,$beneficiarionrodocto,$periodoid);
                $asignaciontipo = 5;
                $obhijoprimariac = $this->model->DatosAsignacionTipo($asignaciontipo,$empleadonrodocto,$beneficiarionrodocto,$periodoid);
                $asignaciontipo = 6;
                $obhijomediosupc = $this->model->DatosAsignacionTipo($asignaciontipo,$empleadonrodocto,$beneficiarionrodocto,$periodoid);
                $asignaciontipo = 7;
                $obhijoescdisc = $this->model->DatosAsignacionTipo($asignaciontipo,$empleadonrodocto,$beneficiarionrodocto,$periodoid);
                //$asignaciontipo = 8;
                //$obhijofnumc = $this->model->DatosAsignacionTipo($asignaciontipo,$empleadonrodocto,$beneficiarionrodocto,$periodoid);
                //$asignaciontipo = 8;
                //$obhijofnumc = $this->model->DatosAsignacionFanNum($asignaciontipo,$empleadonrodocto,$beneficiarionrodocto,$periodoid);
                //-- total asignaciones ----
                $asignacionestotal = $obhijomenorc->obasignaciontipo + $obhijopreescolarc->obasignaciontipo + $obhijoprimariac->obasignaciontipo + $obhijomediosupc->obasignaciontipo + $obhijodiscc->obasignaciontipo + $obhijoescdisc->obasignaciontipo;
               ?>
								<tr>
                  <td style="color:#000000;font-size:13px;"><?php echo $datoshistoricosob->legempleado_apellido.", ".$datoshistoricosob->legempleado_nombres; ?></td>
                  <td style="color:#000000;font-size:13px;"><strong><?php echo $row->empleado; ?></strong></td>
                  <td style="color:#000000;font-size:13px;"><?php echo $datoshistoricosob->beneficiario_apellido.", ".$datoshistoricosob->beneficiario_nombres; ?></td>
                  <td style="color:#000000;font-size:13px;"><strong><?php echo $row->beneficiario; ?></strong></td>
                  <td style="color:#000000;font-size:16px;"><?php echo $obprenatalc->obasignaciontipo; ?></td>
                  <td style="color:#000000;font-size:16px;"><?php echo $obhijomenorc->obasignaciontipo; ?></td>
                  <td style="color:#000000;font-size:16px;"><?php echo $obhijopreescolarc->obasignaciontipo; ?></td>
                  <td style="color:#000000;font-size:16px;"><?php echo $obhijoprimariac->obasignaciontipo; ?></td>
                  <td style="color:#000000;font-size:16px;"><?php echo $obhijomediosupc->obasignaciontipo; ?></td>
                  <td style="color:#000000;font-size:16px;"><?php echo $obhijodiscc->obasignaciontipo; ?></td>
                  <td style="color:#000000;font-size:16px;"><?php echo $obhijoescdisc->obasignaciontipo; ?></td>
                  <td style="color:#000000;font-size:16px;"><?php echo $asignacionestotal; ?></td>
                  <td style="color:#000000;font-size:16px;">--fam num--</td>
                  <td class="dt-right" style="color:#0101DF; font-size:13px; font-weight: bold">--importe--</td>
                  <td class="dt-right" style="color:#FF0000; font-size:13px; font-weight: bold">--reajuste--</td>

                  <td class="dt-right" style="color:#31B404; font-size:13px; font-weight: bold"><?php echo $datoshistoricosob->obimptotal; ?></td>

								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
          <?php endforeach; ?>
          <br>
          <div class="clearfix mb-20">
						<div class="pull-left">
							<h5 class="text-blue">Novedades</h5>
						</div>
					</div>
				</div>
				<!-- Simple Datatable End -->
				<!-- multiple select row Datatable start -->

				<!-- multiple select row Datatable End -->
				<!-- Export Datatable start -->

				<!-- Export Datatable End -->
			</div>
			<?php include('../../includes/footer.php'); ?>
		</div>
	</div>
	<?php include('../../includes/script.php'); ?>
	<script src="../../src/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
  <!--<script src="//cdn.datatables.net/plug-ins/1.10.19/dataRender/datetime.js"></script>-->
	<script src="../../src/plugins/datatables/dataRender/datetime.js"></script>
	<script src="../../src/plugins/datatables/media/js/dataTables.bootstrap4.js"></script>
	<script src="../../src/plugins/datatables/media/js/dataTables.responsive.js"></script>
	<script src="../../src/plugins/datatables/media/js/responsive.bootstrap4.js"></script>
	<!-- buttons for Export datatable -->
	<script src="../../src/plugins/datatables/media/js/button/dataTables.buttons.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/buttons.bootstrap4.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/buttons.print.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/buttons.html5.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/buttons.flash.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/pdfmake.min.js"></script>
	<script src="../../src/plugins/datatables/media/js/button/vfs_fonts.js"></script>
	<script src="../../src/scripts/lugaresdetrabajo.js"></script>
	<script>
		$('document').ready(function(){
				load(1);
			$('.data-table').DataTable({
				scrollCollapse: true,
				autoWidth: false,
				responsive: true,
        columnDefs: [
            {
							 className: "dt-right"
            }
        ],
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],

        columnDefs: [
          {
					targets: 13,
          render: $.fn.dataTable.render.number('.', ',', 2, '$ '),
          },
          {
          targets: 14,
          render: $.fn.dataTable.render.number('.', ',', 2, '$ '),
          },
					{
					targets: 15,
          render: $.fn.dataTable.render.number('.', ',', 2, '$ '),
					}
				],

				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
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
        dom: 'Bfrtip',
				buttons: [
				'copy', 'csv', 'pdf', 'print'
				]
			});
			var table = $('.select-row').DataTable();
			$('.select-row tbody').on('click', 'tr', function () {
				if ($(this).hasClass('selected')) {
					$(this).removeClass('selected');
				}
				else {
					table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			});
			var multipletable = $('.multiple-select-row').DataTable();
			$('.multiple-select-row tbody').on('click', 'tr', function () {
				$(this).toggleClass('selected');
			});
		});
    jQuery(document).ready(function(){
      jQuery("#BtnListarOB").click(function(){
        //--------Obtenemos el valor del input
        //var nrodnis = jQuery('input:checkbox:checked').val();
        var nrodnis = [];
        console.log($("input[name='checkbox[]']"));
        $("input[name='checkbox[]']:checked").each(function(){
          console.log($(this).val());
          nrodnis .push($(this).val());
        });
        //var nrodnis = jQuery("#checkbox").val();
        //var historicodi = jQuery("#mbusquedahistoricodi").val();
        //var historicodf = jQuery("#mbusquedahistoricodf").val();
        var params = {
          "NroDnis" : nrodnis,
          "ContratosC" : '<?php echo $contratosc;?>',
          "Secretaria" : '<?php echo $secretaria;?>',
        };
        //--------llamada al fichero PHP con AJAX
        $.ajax({
          cache: false,
          type: 'POST',
          //dataType:"html",
          url: 'includes/pdf/otrosbeneficiarios-listado.php',
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
</body>
</html>
