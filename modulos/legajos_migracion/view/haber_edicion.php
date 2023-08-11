<!DOCTYPE html>
<html>
<head>
	<?php //$_REQUEST['startIndex']=0;
		$jub=$_REQUEST['id'];

		//$jub=5081;
	  $jubilado_datos = $this->model->JubiladoObtenerLeg($jub);
	  $jubilado_haber = $this->model->JubiladoHaberObtener($jub);

	?>
	<?php include('../../includes/head.php'); ?>
	<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-steps/build/jquery.steps.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa1.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa2.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa3.css">
	<link rel="stylesheet" type="text/css" href="../../src/styles/tableadaptativa4.css">
</head>
<body>
	<?php include('../../includes/header.php'); ?>
	<?php include('../../includes/sidebar.php'); ?>
	<!-- ******** ventanas modal ********** -->
  <?php include("includes/mdl/importe-modi.php");?>
  
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Individuo</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item"><a href="index.php">Jubilado</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edicion de Jubilado</li>
								</ol>
							</nav>
						</div>
						<div class="col-md-6 col-sm-12 text-right">
						</div>
					</div>
				</div>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<h4 class="text-blue"><?php //echo $individuo_datos->individuo_apellido.", ".$individuo_datos->individuo_nombres ?></h4>
						<p class="mb-30 font-18">Conformación de HABER de: <?php echo $jubilado_datos->legajo_apellido .','.$jubilado_datos->legajo_nombres; ?></p>
						<a href="index.php?c=legajo&a=JubiladoEditar&id=<?php echo $jub; ?>&seccion=0"  style="color: green;">
											VOLVER <i class ='icon-copy ion-android-done-all'></i>
										</a>
					</div>
						<div class="wizard-content">
							<form class="tab-wizard wizard-circle wizard" id="" action="?c=Legajo&a=Index" method="post" enctype="multipart/form-data">
								<?php $i=0;//for ($i = 1; $i < 11; $i++){ ?>
								<?php foreach($jubilado_haber as $rowhaber):	?>
								<h5><?php echo "Anio: " . $rowhaber->anio ;$i++?></h5>
								<section>
									<div class="row">
										<table class="data-table table-bordered stripe hover nowrap">
											<thead>
												<tr>
													<th>Mes/Anio</th>
													<th>Importe</th>
													<th>Categoría</th>
													<th>Antiguedad</th>
													<th>Acciones</th>
												</tr>
											</thead>
											<tbody>
												<?php $tot=0;$haber_mensual = $this->model->ListarHaberMensual($jub,$rowhaber->anio);
												foreach($haber_mensual as $rowhabermen):
												?>
												<tr>
													<?php setlocale(LC_TIME, 'es_RA.utf-8','spanish'); $nombrefecha = DateTime::createFromFormat('!m', $rowhabermen->mes);?>
													<td class="dt-right"><?php echo strftime('%B', $nombrefecha->getTimestamp()). ' de '. $rowhaber->anio;?></td>
													<td class="dt-right"><?php echo $rowhabermen->importe_haber_mensual; $tot=$tot+$rowhabermen->importe_haber_mensual ?></td>
													<td class="dt-right"><?php echo $rowhabermen->categoria_id ?></td>
													<td class="dt-right"><?php echo $rowhabermen->importe_antiguedad; ?></td>
													<td>
														<button type="button"
															class="btn btn-primary"
															data-toggle="modal"
															data-target="#ImporteModificar"
															data-titulo="<?php echo "MODIFICAR IMPORTE DE CONFORMACION DE HABER"; ?>"
															data-pid="<?php echo $jub; ?>"
															data-idhaber="<?php echo $rowhabermen->haber_jub_id; ?>"
															data-anioo="<?php echo $rowhabermen->anio;?>"
															data-porant="<?php echo $rowhabermen->porcentaje_antiguedad; ?>"
															data-cat="<?php echo $rowhabermen->categoria_id; ?>"
															data-nombredelmes="<?php echo strftime('%B', $nombrefecha->getTimestamp()). ' de '. $rowhaber->anio;?>"
															data-immp="<?php echo $rowhabermen->importe_haber_mensual;?>"
															>
															<i class='icon-copy fi-pencil'></i>
														</button>
													</td>
												
												</tr>
											<?php endforeach; ?>
											<tr>
												<td class="dt-right"><?php echo "TOTAL";?></td>
												<td class="dt-right"><?php echo $tot; ?></td>
												<td class="dt-right">
												</td>
											</tr>
											</tbody>

										</table>
									</div>
								</section>

							<?php //} ?>
								<?php endforeach; ?>
							</form>
				</div>

				<!-- success Popup html Start -->

				<!-- success Popup html End -->
</div>
		<?php include('../../includes/footer.php'); ?>
		</div>
	</div>
	<?php include('../../includes/script.php'); ?>
	<script src="../../src/plugins/jquery-steps/build/jquery.steps.js"></script>
	<!--<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-custon-file-input/demo.css" />-->
	<link rel="stylesheet" type="text/css" href="../../src/plugins/jquery-custon-file-input/component.css" />
	<script src="../../src/plugins/jquery-custon-file-input/jquery.custom-file-input.js"></script>
	<!--<script src="includes/js/empleadoseditar.js"></script>-->

	<!--<script src="includes/js/conyuge.js"></script>-->
  <script src="includes/js/legajo.js"></script>

	<script>
		jQuery(document).ready(function(){
			
			//--- resultado en vivo de marcaciones ---------
			//$('#price, #tax').on('keyup change paste', function() {
			//jQuery('#cboinsumotipofil, #txtinsumofeciniciofil, #txtinsumofecfinfil').change(function(){
			//jQuery('#cboinsumotipofil, #txtinsumofeciniciofil, #txtinsumofecfinfil').on('change', function prueba(){
			jQuery('#cboinsumotipofil, #txtinsumofeciniciofil, #txtinsumofecfinfil').on('change', function(){
				//cogemos el valor del input

				var nrodocto = <?php echo $jub; ?>;
				var insumotipo = jQuery("#cboinsumotipofil").val();
				var insumofeci = jQuery("#txtinsumofeciniciofil").val();
				var insumofecf = jQuery("#txtinsumofecfinfil").val();
				var params = {
					"NroDocto" : nrodocto,
					"insumoTipo" : insumotipo,
					"insumoFecI" : insumofeci,
					"insumoFecF" : insumofecf
				};
				//llamada al fichero PHP con AJAX
				$.ajax({
					data:  params,
					url: '?c=individuo&a=InsumoEntregada2',
					dataType: 'html',
					type:  'post',
					beforeSend: function () {
						//mostramos gif "cargando"
						//jQuery('#loading_spinner').show();
						//antes de enviar la petición al fichero PHP, mostramos mensaje
						jQuery("#tblinsumoentregada").html("Déjame pensar un poco...");
					},
					success:  function (response) {
						jQuery("#tblinsumoentregada").html(response);
					}
				});
				//yield sleep(2000);
			});


	//--------Descarga de PDF------
	jQuery("#btninsumoimprimir").click(function(){
		//--------Obtenemos el valor del input
		var nrodocto= <?php echo $jub; ?>;
		var insumotipo = jQuery("#cboinsumotipofil").val();
		var insumofeci = jQuery("#txtinsumofeciniciofil").val();
		var insumofecf = jQuery("#txtinsumofecfinfil").val();
		var params = {
			"NroDocto" : nrodocto,
			"insumoTipo" : insumotipo,
			"insumoFecI" : insumofeci,
			"insumoFecF" : insumofecf
		};

		//--------llamada al fichero PHP con AJAX
		$.ajax({
			cache: false,
			type: 'POST',
			//dataType:"html",
			url: '?c=individuo&a=InsumoEntregaListadoEmp',
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
	<script>

			/*
			var form = $(this);
			form.validate({
				errorPlacement: function errorPlacement(error, element) { element.before(error); },
				rules: {
					//confirm: {
					//equalTo: "#empapellido"
					//}
				}
			});
			*/

			$(".tab-wizard").steps({
				headerTag: "h5",
				bodyTag: "section",
				transitionEffect: "fade",
				//saveState: true,
				enableAllSteps: true,
				startIndex: <?php echo $_REQUEST['seccion']; ?>,
				titleTemplate: '<span class="step">#index#</span> #title#',
				labels: {
					current: "current step:",
        	pagination: "Pagination",
        	finish: "Ir a Listado",
        	next: "Siguiente",
        	previous: "Anterior",
        	loading: "Loading ..."
				},
				/*
				onStepChanging: function (event, currentIndex, newIndex){

					var form = $(this);
        	form.validate().settings.ignore = ":disabled,:hidden";

        	return form.valid();


    		},
				*/
				/*
    		onFinishing: function (event, currentIndex){
        	form.validate().settings.ignore = ":disabled";
        	return form.valid();
    		},
				*/
				onFinished: function (event, currentIndex){
					var form = $(this);
          form.submit();
				}
			});
	</script>
</body>
</html>
