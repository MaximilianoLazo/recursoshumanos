<!DOCTYPE html>
<html>
<head>
	<?php //$_REQUEST['startIndex']=0;
		$jub=$_REQUEST['id'];

		//$jub=5081;
	  $jubilado_datos = $this->model->JubiladoObtenerLeg($jub);
	  $datosapo = $this->model->ApoderadoObtenerLeg($jub) ;
	  $liquidacion_datos = $this->model->JubiladoObtenerLiq($jub);
	  $jubilado_hab=  $this->model->JubiladoObtenerHab($jub);
	  $datosbco = $this->model->BancoObtenerLeg($jub) ;
		$datoscat = $this->model->JubiladoObtenerCat($jub) ;
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
	<?php include("includes/mdl/jubilado-modi.php");?>
	<?php include("includes/mdl/conyuge-alta.php");?>
	<?php include("includes/mdl/conyuge-eliminar.php");?>
	<?php include("includes/mdl/conyuge-modi.php");?>
	<?php include("includes/mdl/apoderado-modi.php");?>
	<?php include("includes/mdl/apoderado-alta.php");?>
	<?php include("includes/mdl/familiar-modi.php"); 	?>
	<?php include("includes/mdl/apoderado-eliminar.php"); 	?>
	<?php include("includes/mdl/hijo-modi.php");?>
	<?php include("includes/mdl/empleado-baja.php"); ?>
	<?php include("includes/mdl/haber-calcular.php");?>
	<?php include("includes/mdl/categoria-alta.php");?>
	<?php include("includes/mdl/categoria-eliminar.php");?>
	<?php include("includes/mdl/haber-inicial.php");?>
	<?php include("includes/mdl/sitrevista-alta.php");?>
	<?php include("includes/mdl/empleado-editar-datospersonales.php"); ?>
	<?php include("includes/mdl/empleado-editar-domicilio.php"); ?>

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

									<li class="breadcrumb-item active" aria-current="page">Edicion </li>
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
						<p class="mb-30 font-18">Edición de : <?php echo $jub .'-'. $jubilado_datos->legajo_apellido .','.$jubilado_datos->legajo_nombres; ?></p>
					</div>

					<a href="../legajos_migracion/?c=legajo&a=Pensionados"  style="color: green;">
											VOLVER <i class ='icon-copy ion-android-done-all'></i>
					</a>

					<div class="wizard-content">
						<form class="tab-wizard wizard-circle wizard" id="" action="?c=Legajo&a=Index" method="post" enctype="multipart/form-data">
							<!-- Step 1 -->
							<h5>Datos Personales</h5>
							<section>
               				 <div class="row">
                				<div class="col-md-12">
                    				<div class="form-group">
                      				<div align="right">
									<?php if($jubilado_datos->legajo_activo==1){ ?>
									<button type="button"
												class="btn btn-danger"
												data-toggle="modal"
												data-target="#EmpleadoBaja"
												data-titulo="DAR DE BAJA EMPLEADO"
												data-empid="<?php echo jub; ?>"
												data-empnrodocto="<?php echo $jubilado_datos->legajo_nrodocto; ?>">
												<!--<i class="fa fa-user-times" aria-hidden="true"></i>-->
												<!--<i class="fi-minus-circle"></i>-->
												<!--<i class="ion-power"></i>-->
												<!--<i class="icon-copy fi-prohibited fa-lg"></i>-->
												<i class="icon-copy fi-prohibited fa-lg"></i> DAR DE BAJA
										</button>
									<?php }

                          if(empty($jubilado_datos->legajo_celular) AND empty($jubilado_datos->legajo_telefono) AND empty($jubilado_datos->legajo_mail)){

                          }else{
                            //--- existen datos de contacto
                          }
                        ?>
                        <?php
                          if(empty($jubilado_datos->legajo_direccion)){
                            ?>
                            <button type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#EmpleadoEditarDomicilio"
                                    data-titulo="Editar Datos de Domicilio"
                                    data-empid="<?php echo $jub; ?>"
                                    data-empnrodocto="<?php echo $jubilado_datos->legajo_nrodocto; ?>"
                                    data-empdireccion="<?php echo $jubilado_datos->legajo_direccion; ?>"
                                    data-empdirecnro="<?php echo $jubilado_datos->legajo_direcnro; ?>"
                                    data-empdirecpiso="<?php echo $jubilado_datos->legajo_direcpiso; ?>"
                                    data-empcpostal="<?php echo $jubilado_datos->legajo_codpostal; ?>"
                                    data-emppais="<?php echo $jubilado_datos->pais_id; ?>"
                                    data-empprovincia="<?php echo $jubilado_datos->provincia_id; ?>"
                                    data-empdepartamento="<?php echo $jubilado_datos->departamento_id; ?>"
                                    data-emplocalidad="<?php echo $jubilado_datos->localidad_id; ?>">
                                    <i class="ion-ios-home"></i> AGREGAR Datos de Domicilio
                            </button>
                            <?php
                          }else{
                            //--- Exiten datos de domicilio ---
                          }
                        ?>
                        <button type="button"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#EmpleadoEditarDatosPersonales"
                                data-titulo="Editar Datos Personales"
								data-empid="<?php echo $jub; ?>"
                                data-empnrodocto="<?php echo $jubilado_datos->legajo_nrodocto; ?>"
                                data-empnrocuil="<?php echo $jubilado_datos->legajo_cuil; ?>"
                                data-empnrolegajo="<?php echo $jubilado_datos->cjmdg_personal_nroleg2; ?>"
                                data-empapellido="<?php echo $jubilado_datos->legajo_apellido; ?>"
                                data-empnombres="<?php echo $jubilado_datos->legajo_nombres; ?>"
                                data-empsexo="<?php echo $jubilado_datos->sexo_id; ?>"
                                data-empestadocivil="<?php echo $jubilado_datos->estado_civil_id; ?>"
                                data-empfecnac="<?php echo $jubilado_datos->legajo_fecnacto; ?>"
                                data-empfecing="<?php echo $jubilado_datos->legajo_fecing; ?>"
								data-empdisc="<?php echo $jubilado_datos->legajo_disc; ?>"
                                data-empmovimiento="2">
                                <i class="fa fa-edit" aria-hidden="true"></i> Editar Datos Personales
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<?php
											$nrodocto = $jubilado_datos->legajo_nrodocto;
											//$legcontrato = $this->model->ObtenerContrato($nrodocto);
											?>
											<input type="hidden" name="empid" id="empid" value="<?php echo $jub; ?>">
											<input type="hidden" name="empnrodocumento" id="empnrodocumento" value="<?php echo $jubilado_datos->legajo_nrodocto; ?>">
                      <input type="hidden" name="empppdl" id="empppdl" value="<?php echo $jubilado_datos->pais_id."-".$jubilado_datos->provincia_id."-".$jubilado_datos->departamento_id."-".$emp->localidad_id; ?>">
											<!--<input type="hidden" name="contratoid" id="contratoid" value="<?php //echo $emp->legcontrato_id; ?>">-->
											<!--<input type="hidden" name="imputacion" id="imputacion" value="<?php //echo $legcontrato->imputacion_id."-".$legcontrato->impactividad_id; ?>">-->
										</div>
									</div>
								</div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-12">
    					<div class="form-group">
                          <?php
      							$img = '../../imagenes/legajos/'.$jubilado_datos->legajo_imagen.'.jpg';
      							if(file_exists($img)){
      							   ?>
                              			<img src="../../imagenes/legajos/<?php echo $jubilado_datos->legajo_imagen; ?>.jpg" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
      									<?php
      									}else{
          									if($jubilado_datos->sexo_id == 1){
      									    ?>
                              					<img src="../../imagenes/legajos/avatar-masculino.jpg" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
      										    	<?php
      												}else{
													?>
													<img src="../../imagenes/legajos/avatar-femenino.jpg" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
													<?php
	   											}
     							}
      						?>
    					</div>
                      </div>
                      <div class="col-md-12">
                        <button type="button" class="btn btn-success" style="font-size: 13px;">
                          <!--<i class="ion-android-camera"></i>-->
                          <!--<i class="fa fa-camera-retro" aria-hidden="true"></i>-->
                          <!--<i class="fa fa-camera" aria-hidden="true"></i>-->
                          <!--<i class="ion-camera"></i>-->
                          <i class="fa fa-camera-retro" aria-hidden="true"></i> Tomar Foto
                        </button>
                        <button type="button" class="btn btn-success" style="font-size: 13px;">
                          <i class="ion-image"></i> Subir Foto
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="row">
    									<div class="col-md-4">
    										<div class="form-group">
    											<label for="txtnrodoctom">DNI:</label>
    											<input type="text" name="txtnrodoctom" id="txtnrodoctom" value="<?php echo $jubilado_datos->legajo_nrodocto; ?>" class="form-control" disabled>
    										</div>
    									</div>
                      <div class="col-md-4">
    										<div class="form-group">
    											<label for="txtempnrocuilm">CUIL :</label>
    											<input type="text" name="txtempnrocuilm" id="txtempnrocuilm" value="<?php echo $jubilado_datos->legajo_cuil; ?>" class="form-control" disabled>
    										</div>
    									</div>
                      <div class="col-md-4">
    										<div class="form-group">
    											<label for="txtempnrolegajom">Nro. de Legajo:</label>
    											<input type="text" name="txtempnrolegajom" id="txtempnrolegajom" value="<?php echo $jubilado_datos->cjmdg_personal_nroleg2; ?>" class="form-control" disabled>
    										</div>
    									</div>
    								</div>
                    <div class="row">
    									<div class="col-md-12">
    										<div class="form-group">
    											<label for="txtempapellidom">Apellido:</label>
    											<input type="text" name="txtempapellidom" id="txtempapellidom" value="<?php echo $jubilado_datos->legajo_apellido; ?>" class="form-control" required disabled>
    										</div>
    									</div>
    								</div>
                    <div class="row">
                      <div class="col-md-12">
    										<div class="form-group">
    											<label for="txtempnombresm">Nombres:</label>
    											<input type="text" name="txtempnombresm" id="txtempnombresm" value="<?php echo $jubilado_datos->legajo_nombres; ?>" class="form-control" disabled>
    										</div>
    									</div>
                    </div>
                    <div class="row">
    									<div class="col-md-6">
    										<div class="form-group">
    											<label for="cboempsexom">Sexo:</label>
    											<select name="cboempsexom" id="cboempsexom" class="custom-select form-control" disabled>
    												<option></option>
    													<?php foreach($this->model->Sexos() as $row): ?>
    															<option value="<?php echo $row->sexo_id; ?>"<?php if (!(strcmp($row->sexo_id, $jubilado_datos->sexo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->sexo_nombre; ?></option>
    												<?php endforeach; ?>
    											</select>
    										</div>
    									</div>
    									<div class="col-md-6">
    										<div class="form-group">
    											<label for="cboempestadocivilm">Estado Civil:</label>
    											<select name="cboempestadocivilm" id="cboempestadocivilm" class="custom-select form-control" disabled>
    												<option></option>
    													<?php foreach($this->model->EstadosC() as $row): ?>
    															<option value="<?php echo $row->estcivil_id; ?>"<?php if (!(strcmp($row->estcivil_id, $jubilado_datos->estado_civil_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->estcivil_nombre; ?></option>
    												<?php endforeach; ?>
    											</select>
    										</div>
    									</div>
                    </div>
                    <div class="row">
    									<div class="col-md-6">
    										<div class="form-group">
    											<label for="cboempestadocivilm">Fecha de Nacimiento:</label>
    											<input type="date" name="cboempestadocivilm" id="cboempestadocivilm" class="form-control" value="<?php echo $jubilado_datos->legajo_fecnacto; ?>" placeholder="Select Date" disabled>
    										</div>
    									</div>
    					<div class="col-md-6">
    						<div class="form-group">
								<label for="txtempfecingm">Fecha de Jubilación:</label>
								<input type="date" name="txtempfecingm" id="txtempfecingm" value="<?php echo $jubilado_datos->legajo_fecing; ?>" class="form-control" disabled>
    						</div>
    					</div>
										<div class="col-md-6">
    										<div class="form-group">
                         						<label for="txtempfecingm">Fecha de Baja:</label>
                          						<input type="date" name="txtempfecegrm" id="txtempfecegrm" value="<?php echo $jubilado_datos->legajo_fecegr; ?>" class="form-control" disabled>
    										</div>
    									</div>
										<div class="col-md-6">
											<div class="form-group">
												<div class="form-group">
													<label for="txtdisc"></label>
												</div>
												<label for="hijodisc"><em>&nbsp;Discapacidad?</em></label>
												<input type="checkbox" name="hijodisc" id="hijodisc" value="" <?php if($jubilado_datos->legajo_disc==0){echo "0";}else{echo "checked";}?> class="custom-control-input" disabled>
											</div>
    									</div>
    								</div>
                  </div>
                </div>
                <!--//////////Final formulario empleado - datos personales///////// -->
                <?php
                  if(empty($jubilado_datos->legajo_direccion)){
                    //--- no existen datos de domincilio
                  }else{
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div align="right">
                            <button type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#EmpleadoEditarDomicilio"
                                    data-titulo="Editar Datos de Domicilio"
																		data-empid="<?php echo $jub; ?>"
                                    data-empnrodocto="<?php echo $jubilado_datos->legajo_nrodocto; ?>"
                                    data-empdireccion="<?php echo $jubilado_datos->legajo_direccion; ?>"
                                    data-empdirecnro="<?php echo $jubilado_datos->legajo_direcnro; ?>"
                                    data-empdirecpiso="<?php echo $jubilado_datos->legajo_direcpiso; ?>"
                                    data-empcpostal="<?php echo $jubilado_datos->legajo_codpostal; ?>"
                                    data-emppais="<?php echo $jubilado_datos->pais_id; ?>"
                                    data-empprovincia="<?php echo $jubilado_datos->provincia_id; ?>"
                                    data-empdepartamento="<?php echo $jubilado_datos->departamento_id; ?>"
                                    data-emplocalidad="<?php echo $jubilado_datos->localidad_id; ?>">
                                    <i class="ion-ios-home"></i> Editar Datos de Domicilio
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
    								<div class="row">
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="txtempdireccionm">Direccion:</label>
    											<input type="text" name="txtempdireccionm" id="txtempdireccionm" value="<?php echo $jubilado_datos->legajo_direccion; ?>" class="form-control" disabled>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="txtempdirenrom">Numero:</label>
    											<input type="text" name="txtempdirenrom" id="txtempdirenrom" value="<?php echo $jubilado_datos->legajo_direcnro; ?>" class="form-control" disabled>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="txtempdirecpisom">Piso:</label>
    											<input type="text" name="txtempdirecpisom" id="txtempdirecpisom" value="<?php echo $jubilado_datos->legajo_direcpiso; ?>" class="form-control" disabled>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="txtempcpostalm">Codigo Postal:</label>
    											<input type="text" name="txtempcpostalm" id="txtempcpostalm" value="<?php echo $jubilado_datos->legajo_codpostal; ?>" class="form-control" disabled>
    										</div>
    									</div>
                      <div class="col-md-3">
    										<div class="form-group">

											<label for="cboemppaism">Pais:</label>
    											<select name="cboemppaism" id="cboemppaism" class="custom-select form-control" disabled>
    												<option></option>
    													<?php foreach($this->model->Paises($jubilado_datos->pais_id) as $row): ?>
    															<option value="<?php echo $row->pais_id; ?>"<?php if (!(strcmp($row->pais_id, $jubilado_datos->pais_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->pais_nombre; ?></option>
    												<?php endforeach; ?>
    											</select>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="cboempprovinciam">Provincia:</label>
    											<select name="cboempprovinciam" id="cboempprovinciam" class="custom-select form-control" disabled>
												<?php foreach($this->model->Provincias($jubilado_datos->provincia_id) as $row): ?>
												<option value="<?php echo $row->provincia_id; ?>"<?php if (!(strcmp($row->provincia_id, $jubilado_datos->provincia_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->provincia_nombre; ?></option>
												<?php endforeach; ?>
    											</select>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="cboempdepartamentom">Departamento:</label>
    											<select name="cboempdepartamentom" id="cboempdepartamentom" class="custom-select form-control" disabled>
												<?php foreach($this->model->Departamentos($jubilado_datos->departamento_id) as $row): ?>
												<option value="<?php echo $row->departamento_id; ?>"<?php if (!(strcmp($row->departamento_id, $jubilado_datos->departamento_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->departamento_nombre; ?></option>
												<?php endforeach; ?>
    											</select>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="cboemplocalidadm">Localidad:</label>
    											<select name="cboemplocalidadm" id="cboemplocalidadm" class="custom-select form-control" disabled>
												<?php foreach($this->model->Localidades($jubilado_datos->localidad_id) as $row): ?>
												<option value="<?php echo $row->localidad_id; ?>"<?php if (!(strcmp($row->localidad_id, $jubilado_datos->localidad_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->localidad_nombre; ?></option>
												<?php endforeach; ?>
    											</select>
    										</div>
    									</div>
    								</div>
                    <?php
                  }
                ?>
                <!--//////////Final formulario empleado - datos de domicilio///////// -->
                <?php
                  if(empty($jubilado_datos->legajo_celular) AND empty($jubilado_datos->legajo_telefono) AND empty($jubilado_datos->legajo_mail)){
                    //--- no existen datos de contacto
                  }else{
                    ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div align="right">
                            <button type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#EmpleadoEditarContacto"
                                    data-titulo="Editar Datos de Contacto"
                                    data-empid="<?php echo $jub; ?>"
                                    data-empnrodocto="<?php echo $jubilado_datos->legajo_nrodocto; ?>"
                                    data-empcelular="<?php echo $jubilado_datos->legajo_celular; ?>"
                                    data-emptelefono="<?php echo $jubilado_datos->legajo_telefono; ?>"
                                    data-empemail="<?php  echo $jubilado_datos->legajo_mail; ?>">
                                    <!--<i class="fa fa-vcard-o" aria-hidden="true"></i>-->
                                    <i class="icon-copy ion-social-whatsapp-outline"></i> Editar Datos de Contacto
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="txtempcelularm">Celular:</label>
                          <input type="number" name="txtempcelularm" id="txtempcelularm" value="<?php echo $jubilado_datos->legajo_celular; ?>" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="txtemptelefonom">Telefono :</label>
                          <input type="number" name="txtemptelefonom" id="txtemptelefonom" value="<?php echo $jubilado_datos->legajo_telefono; ?>" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="txtempemailm">Email:</label>
                          <input type="email" name="txtempemailm" id="txtempemailm" class="form-control" value="<?php echo $jubilado_datos->legajo_mail; ?>" disabled>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                ?>
			</section>

			<h5>Situación de Revista</h5>
							<section>
               				 <div class="row">
                				<div class="col-md-12">
                    				<div class="form-group">
                      				<div align="right">

                        <?php
                          if(empty($datosbco->legajo_id)){
                            ?>
                            <button type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#SitRevistaAlta"
                                    data-titulo="Alta Datos Situación de Revista"
																		data-empid="<?php echo $jub; ?>"
																		data-empsuc="<?php echo $datosbco->sucursal; ?>"
																		data-empbanco="<?php echo $datosbco->numero_cuenta; ?>"
																		data-emptipo="<?php echo $datosbco->legajo_tipo_id; ?>"
																		data-empcat="<?php echo $datoscat->categoria_jub_id; ?>"
                                    <i class="ion-ios-home"></i> AGREGAR Datos Sit.Revista
                            </button>
                            <?php
                          }else{
                            //--- Exiten datos de domicilio ---
                          }
                        ?>
												<button type="button"
																class="btn btn-primary"
																data-toggle="modal"
																data-target="#SitRevistaAlta"
																data-titulo="Editar Datos Situación de Revista"
																data-empid="<?php echo $jub; ?>"
																data-empsuc="<?php echo $datosbco->sucursal; ?>"
																data-empbanco="<?php echo $datosbco->numero_cuenta; ?>"
																data-emptipo="<?php echo $datosbco->legajo_tipo_id; ?>"
																data-empcat="<?php echo $datoscat->categoria_jub_id; ?>"
																<i class="ion-ios-home"></i> Editar Datos Sit.Revista
												</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                   <div class="col-md-9">
                    <div class="row">
    									<div class="col-md-4">
    										<div class="form-group">
    											<label for="txtnrodoctom">Situación de Revista:</label>
    											<input type="text" name="txtcatjub" id="txtcatjub" value="<?php echo $datosbco->legajo_tipo_nombre; ?>" class="form-control" disabled>
    										</div>
    									</div>

											<div class="col-md-4">
    										<div class="form-group">
    											<label for="txtnrodoctom">Categoría de Jubilación:</label>
    											<input type="text" name="txtsitrevista" id="txtsitrevista" value="<?php echo $datoscat->categoria_jub_abreviacion; ?>" class="form-control" disabled>
    										</div>
    									</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="txtempfecingm">Sucursal:</label>
													<input type="text" name="txtsuc" id="txtsuc" value="<?php echo $datosbco->sucursal; ?>" class="form-control" disabled>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="txtempfecingm">N° de Cuenta:</label>
													<input type="text" name="txtbco" id="txtbco" value="<?php echo substr($datosbco->numero_cuenta,0,-1).'-'.substr($datosbco->numero_cuenta,-1); ?>" class="form-control" disabled>
												</div>
											</div>
										</div>
                  </div>
                </div>
                <!--//////////Final formulario empleado - datos personales///////// -->

                <!--//////////Final formulario empleado - datos de domicilio///////// -->

							</section>
								<h5>Conyuge</h5>
								<section>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div align="right">
												<button type="button"
																class="btn btn-primary"
																	data-toggle="modal"
																	data-target="#ConyugeAlta"
																	data-titulo="<?php echo "AGREGAR NUEVO CONYUGE"; ?>"
																	data-pid="<?php echo $jub; ?>"
																	data-nom="<?php echo $jubilado_datos->legajo_apellido .','.$jubilado_datos->legajo_nombres; ?>"
																	>
																ALTA CONYUGE
													</button>
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
				 	                       	<i class="icon-copy fi-pencil"></i>
				 	                </button>

															<button type="button"
																			class="btn btn-danger"
																			data-toggle="modal"
																			data-target="#ConyugeEliminar"
																			data-titulo="<?php echo "ELIMINAR CONYUGE"; ?>"
																			data-pid="<?php echo $fam->conyuge_id; ?>"
																			data-jub="<?php echo $jub;?>"
																			data-nombre="<?php echo $fam->conyuge_apellido.", ".$fam->conyuge_nombres;; ?>"
																			><i class='icon-copy fa fa-trash'></i>
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
													<button type="button"
												class="btn btn-primary"
																	data-toggle="modal"
																	data-target="#FamiliarEditar"
																	data-titulo="<?php echo "AGREGAR NUEVO HIJO"; ?>"
																	data-pid="<?php echo $jub; ?>"
																	data-nom="<?php echo $jubilado_datos->legajo_apellido .','.$jubilado_datos->legajo_nombres; ?>"
																	>
																ALTA HIJO
													</button>
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
														<th>N&deg; Documento</th>
														<th>Apellido y Nombres</th>
														<th>Fecha Nacimiento</th>
														<th>Acciones</th>
													</tr>
												</thead>
												<tbody>
												 <?php
													foreach($this->model->FamiliaresListar($jub) as $fam):
														$fecha_nacimiento = date("d/m/Y", strtotime($fam->leghijo_fecnacto));
												 ?>
													<tr>

														<td class="dt-right"><?php echo $fam->leghijo_nrodocto; ?></td>
														<td><?php echo $fam->leghijo_apellido.", ".$fam->leghijo_nombres; ?></td>
														<td class="dt-right"><?php echo $fecha_nacimiento; ?></td>

														<td class="dt-right">
																	<button type="button"
																				class="btn btn-primary"
																				data-toggle="modal"
																				data-target="#HijoModificar"
																				data-titulo="<?php echo "Modificar Datos Hijo"; ?>"
																				data-jub="<?php echo $jub; ?>"
																				data-pid1="<?php echo $fam->leghijo_id; ?>"
																				data-dni="<?php echo $fam->leghijo_nrodocto; ?>"
																				data-ape="<?php echo $fam->leghijo_apellido; ?>"
																				data-nom="<?php echo $fam->leghijo_nombres; ?>"
																				data-fec="<?php echo $fam->leghijo_fecnacto; ?>"
																				data-tipodoc="<?php echo $fam->leghijo_tipodocto; ?>"
																				data-dir="<?php echo $fam->leghijo_direccion; ?>">
							 	                       	<i class="icon-copy fi-pencil"></i>
					 	               				</button>
															<button type="button"
																	class="btn btn-danger"
																	data-toggle="modal"
																	data-target="#IndividuoEliminar"
																	data-titulo="<?php echo "Dar de Baja HIJO"; ?>"
																	data-pid="<?php echo $fam->leghijo_id; ?>"
																	>
																	<i class='icon-copy fa fa-trash'></i>
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
													class="btn btn-primary"
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
																			data-cel="<?php echo $row->legapoderado_celular; ?>"
																			>
																			<i class='icon-copy fi-pencil'></i>
															</button>

														</a>
															<button type="button"
																			class="btn btn-primary"
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



						<h5>Haber Jubilatorio</h5>
						<section>

							<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<div align="right">
												<?php $haber_anual = $this->model->ListarHaberAnual($jub); ?>
												<button type="button"
															class="btn btn-primary"
															data-toggle="modal"
															data-target="#ImporteModificar"
															data-titulo="<?php echo "MODIFICAR IMPORTE DE CONFORMACION DE HABER"; ?>"
															data-pid="<?php echo $jub; ?>"
															data-nombre1="<?php echo $haber_anual[0]->legajo_apellido .','.$haber_anual[0]->legajo_nombres; ?>"
															data-immp="<?php echo $haber_anual[0]->importe_haber;?>"
															>
															MODIFICAR HABER
												</button>
											</div>
										</div>
									</div>
							</div>

							<div class="pd-10 bg-white border-radius-4 box-shadow mb-30">
								<div class="clearfix mb-20">
									<div class="pull-left">
										<h5 class="text-blue"><?php if($jubilado_datos->categoria_jub_id==15 or $jubilado_datos->categoria_jub_id==16 or $jubilado_datos->categoria_jub_id==17){ echo 'Haber';}else{echo 'Haber Jubilatorio'; }?></h5>
									</div>
								</div>
								<div class="row">
									<table class="data-table table-bordered stripe hover nowrap">
										<thead>
											<tr>
												<th>Año</th>
												<th>Importe</th>

											</tr>
										</thead>
										<tbody>
										 	<?php
											foreach($haber_anual as $rowhaber):
												$fecha_j=date_create($rowhaber->fecha_jub);
										 	?>
											<tr>
											<td class="dt-right"><?php echo date_format($fecha_j,'d/m/Y');?></td>
											 <td class="dt-right"><?php echo $rowhaber->importe_haber;  ?></td>
											</tr>
										<?php endforeach; ?>


										</tbody>

									</table>
								</div>

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
