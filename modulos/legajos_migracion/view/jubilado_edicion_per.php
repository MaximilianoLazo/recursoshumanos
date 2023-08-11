<!DOCTYPE html>
<html>
<head>
	<?php //$_REQUEST['startIndex']=0;
		$jub=$_REQUEST['id'];

		//$jub=5081;
	  $jubilado_datos = $this->model->JubiladoObtenerLeg($jub);
	  $datosapo = $this->model->ApoderadoObtenerLeg($jub) ;


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

	<?php include("includes/mdl/jubilado-modi.php");?>
	<?php include("includes/mdl/conyuge-alta.php");?>
	<?php include("includes/mdl/conyuge-eliminar.php");?>
	<?php include("includes/mdl/conyuge-modi.php");?>
	<?php include("includes/mdl/apoderado-modi.php");?>
	<?php include("includes/mdl/apoderado-alta.php");?>
	<?php include("includes/mdl/familiar-modi.php"); 	?>
	<?php include("includes/mdl/apoderado-eliminar.php"); 	?>
  	<?php include("includes/mdl/hijo-modi.php");?>


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
						<p class="mb-30 font-18">Edición de Jubilado: <?php echo $jub .'-'. $jubilado_datos->legajo_apellido .','.$jubilado_datos->legajo_nombres; ?></p>
					</div>
					<div class="wizard-content">
						<form class="tab-wizard wizard-circle wizard" id="" action="?c=Legajo&a=Index" method="post" enctype="multipart/form-data">
							<!-- Step 1 -->
  					<h5>Datos Personales</h5>
						<section>
                <p class='align:right'>

					<button type="button"
							class="btn btn-outline-secondary"
	                        data-toggle="modal"
	                        data-target="#JubiladoModificar"
	                        data-titulo="<?php echo "Modificar jubilado"; ?>"
	                        data-pid="<?php echo $jub; ?>"
	                       	<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
											Modificar Datos Personales
	                </button>
              	</p>
                <div class="row">
                  <div class="col-12 col-sm-6 col-md-6">
                    <div class="form-group">
                      <label for="cbotipodocumento" class="control-label">Tipo documento:</label>
                      <select name="cbotipodocumento" id="cbotipodocumento" class="custom-select form-control" disabled>
                         <option></option>
                           <?php foreach($this->model->DniTiposListar() as $row):  ?>
                               <option value="<?php echo $row->doctipo_id; ?>"<?php if (!(strcmp($row->doctipo_id, $jubilado_datos->tipo_docto_id)))
                                {echo "selected=\"selected\"";} ?> > <?php  echo $row->doctipo_nombre;?> </option>
                           <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
						<div class="col-12 col-sm-6 col-md-6"  >
		                <div class="form-group">
		                  <label for="txtnrodocto" class="control-label">Número:</label>
		                  <input type="number" name="txtnrodocto" id="txtnrodocto" value="<?php echo $jubilado_datos->legajo_nrodocto; ?>" class="form-control form-control-sm" placeholder="" disabled>
		                </div>
		              </div>
                </div>
                <div class="row">
		              <div class="col-12 col-sm-6 col-md-6">
		                <div class="form-group">
		                  <label for="txtapellido" class="control-label">Apellido: </label>
		                  <input type="text" name="txtapellido" id="txtapellido" value="<?php echo $jubilado_datos->legajo_apellido; ?>" class="form-control form-control-sm" disabled>
		                </div>
		              </div>
		              <div class="col-12 col-sm-6 col-md-6">
		                <div class="form-group">
		                  <label for="txtnombres" class="control-label">Nombres:</label>
		                  <input type="text" name="txtnombres" id="txtnombres" value="<?php echo $jubilado_datos->legajo_nombres; ?> "class="form-control form-control-sm"  disabled>
		                </div>
		              </div>
            		</div>
		            <div class="row">
		              <div class="col-12 col-sm-4 col-md-4">
		                <div class="form-group">
		                  <label for="txtfnac" class="control-label">Fecha de Nacimiento:</label>
		                  <input type="Date" name="textfecha" id="textfecha" class="form-control form-control-sm"  value="<?php echo $jubilado_datos->legajo_fecnacto; ?>" disabled>
		                </div>
		              </div>
							<div class="col-12 col-sm-4 col-md-4">
										<div class="form-group">
											<label for="cbosexo" class="control-label" >Sexo:</label>
											<select name="cbosexo" id="cbosexo" class="custom-select form-control" disabled>
												 <option></option>
													 <?php foreach($this->model->SexoListar() as $row):  ?>
															 <option value="<?php echo $row->sexo_id; ?>"<?php if (!(strcmp($row->sexo_id, $jubilado_datos->sexo_id)))
																{echo "selected=\"selected\"";} ?> > <?php  echo $row->sexo_nombre;?> </option>
													 <?php endforeach; ?>
											</select>
										</div>
									</div>
		              <div class="col-12 col-sm-4 col-md-4">
		                <div class="form-group">
		                  <label for="cboecivil" class="control-label">Estado Civil:</label>
		                  <select name="cboecivil" id="cboecivil" class="custom-select form-control" disabled>
		                     <option></option>
		                     <?php foreach($this->model->EstadoCivilListar() as $row): ?>
		                     <option value="<?php echo $row->estcivil_id; ?>"<?php if (!(strcmp($row->estcivil_id, $jubilado_datos->estado_civil_id)))
		                      {echo "selected=\"selected\"";} ?> > <?php echo $row->estcivil_nombre;?> </option>
		                       <?php endforeach; ?>
		                 </select>
		                </div>
		              </div>
		            </div>
            		<div class="row">
            			<div class="col-12 col-sm-6 col-md-6">
			              <div class="form-group">
			                <label for="txtcelular" class="control-label">Celular</label>
			                <input type="number" name="txtcelular" id="txtcelular" value= "<?php echo $jubilado_datos->legajo_celular ?>" class="form-control form-control-sm" placeholder="" disabled>
			              </div>
                  </div>
									<div class="col-12 col-sm-6 col-md-6">
										<div class="form-group">
											<label for="cboobrasocial" class="control-label">Obra Social:</label>
											 <input type="text" name="txtos" id="txtos" value= "<?php echo $jubilado_datos->obra_social_nombre ?>" class="form-control form-control-sm" placeholder="" disabled>
										</div>
									</div>
                </div>
								<div class="row">
									<div class="col-xs-12 col-sm-6 col-lg-6">
										<div class="form-group">
											<label for="txtcalle" class="control-label">Calle: </label>
											<input type="text" name="txtcalle" id="txtcalle"  value="<?php echo $jubilado_datos->legajo_direccion; ?>"  class="form-control form-control-sm" disabled>
										</div>
									</div>
										<div class="col-xs-12 col-sm-6 col-lg-6">
													<div class="form-group">
													<label for="cbolocalidad" class="control-label">Localidad:</label>
													<select name="cbolocalidad" id="cbolocalidad" class="custom-select form-control" disabled>
														<option></option>
															<?php foreach($this->model->LocalidadListar() as $row): ?>
																<option value="<?php echo $row->localidad_id; ?>"<?php if (!(strcmp($row->localidad_id, $jubilado_datos->localidad_id)))
																 {echo "selected=\"selected\"";} ?> > <?php echo $row->localidad_nombre;?> </option>
															<?php endforeach; ?>
													</select>
													</div>
											</div>

								</div>
                 <br>
                  <br>
								</section>
								<h5>Conyuge</h5>
								<section>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div align="right">

												</div>
											</div>
										</div>
									</div>

									<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
										<div class="clearfix mb-20">
											<div class="pull-left">
												<h5 class="text-blue">Conyuge</h5>
											</div>
										</div>
										<div class="row">

										</div>
										<div class="row">
											<table class="data-table table-bordered stripe hover nowrap">
												<thead>
													<tr>
														<th>Tipo Documento</th>
														<th>N&deg; Documento</th>
														<th>Apellido y Nombres</th>
														<th>Fecha Nacimiento</th>
														<th>Acciones</th>
													</tr>
												</thead>
												<tbody>
												 <?php
													foreach($this->model->ConyugeListar($jub) as $fam):
														$fecha_nacimiento = date("d/m/Y", strtotime($fam->conyuge_fecnato));
												 ?>
													<tr>
														<td class="dt-right"><?php echo $fam->doctipo_nombre; ?></td>
														<td class="dt-right"><?php echo $fam->conyuge_nrodocto; ?></td>
														<td><?php echo $fam->conyuge_apellido.", ".$fam->conyuge_nombres; ?></td>
														<td class="dt-right"><?php echo $fecha_nacimiento; ?></td>

														<td class="dt-right">

														</a>
														<button type="button"
																	class="btn btn-primary"
																	data-toggle="modal"
																	data-target="#ConyugeModificar"
																	data-titulo="<?php echo "Modificar Datos Conyuge"; ?>"
																	data-jub="<?php echo $jub; ?>"
																	data-pid="<?php echo $fam->conyuge_id; ?>"
																	data-dnitipo="<?php echo $fam->conyuge_tipodocto ?>"
																	data-dninro="<?php echo $fam->conyuge_nrodocto; ?>"
																	data-ape="<?php echo $fam->conyuge_apellido; ?>"
																	data-nom="<?php echo $fam->conyuge_nombres; ?>"
																	data-fec="<?php echo $fam->conyuge_fecnato; ?>"
																	data-cel="<?php echo $fam->conyuge_celular; ?>"
																	data-dir="<?php echo $fam->conyuge_direccion; ?>">
																	<i class="icon-copy ion-android-done-all"></i>
				 	                					</button>

															<?php $con=$fam->conyuge_id ?>
														</td>
													</tr>
												<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</div>

								</section>


								<h5>Hijos</h5>
								<section>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div align="right">

												</div>
											</div>
										</div>
									</div>

									<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
										<div class="clearfix mb-20">
											<div class="pull-left">
												<h5 class="text-blue">Listado de Hijos</h5>
											</div>
										</div>
										<div class="row">

										</div>
										<div class="row">
											<table class="data-table table-bordered stripe hover nowrap">
												<thead>
													<tr>
														<th>Tipo Documento</th>
														<th>N&deg; Documento</th>
														<th>Apellido y Nombres</th>
														<th>Fecha Nacimiento</th>
														<th>Acciones</th>
													</tr>
												</thead>
												<tbody>
												 <?php
													foreach($this->model->FamiliaresListar($jub) as $fam):
														$fecha_nacimiento = date("d/m/Y", strtotime($fam->hijo_fecnacto));
												 ?>
													<tr>
														<td class="dt-right"><?php echo $fam->doctipo_nombre; ?></td>
														<td class="dt-right"><?php echo $fam->hijo_nrodocto; ?></td>
														<td><?php echo $fam->hijo_apellido.", ".$fam->hijo_nombres; ?></td>
														<td class="dt-right"><?php echo $fecha_nacimiento; ?></td>

														<td class="dt-right">

															<button type="button"
																		class="btn btn-primary"
																		data-toggle="modal"
																		data-target="#HijoModificar"
																		data-titulo="<?php echo "Modificar Datos Hijo"; ?>"
																		data-jub="<?php echo $jub; ?>"
																		data-pid="<?php echo $fam->conyuge_id; ?>"
																		data-dnitipo="<?php echo $fam->hijo_tipodocto ?>"
																		data-dninro="<?php echo $fam->hijo_nrodocto; ?>"
																		data-ape="<?php echo $fam->hijo_apellido; ?>"
																		data-nom="<?php echo $fam->hijo_nombres; ?>"
																		data-fec="<?php echo $fam->hijo_fecnato; ?>"
																		data-cel="<?php echo $fam->hijo_celular; ?>"
																		data-dir="<?php echo $fam->hijo_direccion; ?>"
																		>
																		<i class="icon-copy ion-android-done-all"></i>
					 	                </button>

														</td>
													</tr>
												<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									</div>

								</section>
								<h5>Apoderado</h5>
								<section>
									<?php if(isset($datosapo)){$apo=0;?>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div align="right">

													<button type="button"
													class="btn btn-outline-secondary"
																	data-toggle="modal"
																	data-target="#ApoderadoAlta"
																	data-titulo="<?php echo 'AGREGAR NUEVO APODERADO DE:'.$jubilado_datos->legajo_apellido .','.$jubilado_datos->legajo_nombres; ; ?>"
																	data-juid="<?php echo $jub; ?>"
																	data-nombre="<?php echo $jubilado_datos->legajo_apellido .','.$jubilado_datos->legajo_nombres; ?>"
																	>
																ALTA APODERADO
													</button>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
									<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
										<div class="clearfix mb-20">
											<div class="pull-left">
												<h5 class="text-blue">Apoderado</h5>
											</div>
										</div>
											<?php if(isset($datosapo)){ ?>
										<div class="row">
											<table class="data-table table-bordered stripe hover nowrap">
												<thead>
													<tr>
														<th>N&deg; Documento</th>
														<th>Apellido y Nombres</th>
														<th>Dirección</th>
														<th>Acciones</th>
													</tr>
												</thead>
												<tbody>
												 <?php
												 	foreach($datosapo as $row):
												 ?>
													<tr>
														<td class="dt-right"><?php echo $row->legapoderado_nrodocto;?></td>
														<td><?php echo $row->legapoderado_apellido.", ".$row->legapoderado_nombres; ?></td>
														<td class="dt-right"><?php echo $row->legapoderado_direccion; ?></td>

														<td class="dt-right">

															<button type="button"
																			class="btn btn-primary"
																			data-toggle="modal"
																			data-target="#ApoderadoModificar"
																			data-titulo="<?php echo "MODIFICAR APODERADO"; ?>"
																			data-pid="<?php echo $row->legapoderado_id; ?>"
																			data-jid="<?php echo $row->legajo_id; ?>"
																			data-tipodni="<?php echo $row->legapoderado_tipo_doc; ?>"
																			data-dni="<?php echo $row->legapoderado_nrodocto; ?>"
																			data-nom="<?php echo $row->legapoderado_nombres; ?>"
																			data-ape="<?php echo $row->legapoderado_apellido; ?>"
																			data-dir="<?php echo $row->legapoderado_direccion; ?>"
																			data-cel="<?php echo $row->legapoderado_celular; ?>">
																			<i class ='icon-copy ion-android-done-all'></i>

														</button>

														</a>
															<button type="button"
																			class="btn btn-danger"
																			data-toggle="modal"
																			data-target="#ApoderadoEliminar"
																			data-titulo="<?php echo "BORRAR APODERADO"; ?>"
																			data-dpid="<?php echo $row->legapoderado_id; ?>"
																			data-jubiid="<?php echo $row->legajo_id; ?>"
																			data-nombre="<?php echo $row->legapoderado_apellido.", ".$row->legapoderado_nombres; ?>"
																			>
																			<i class='icon-copy fa fa-trash'></i>
															</button>
														</td>
													</tr>
												<?php endforeach; ?>
												</tbody>
											</table>
										</div>
									<?php } else {
											echo "<h5>"."No existe Apoderado cargado"."</h5>"; }?>
									</div>

								</section>

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
