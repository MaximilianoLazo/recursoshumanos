<?php
session_start();
if(!isset($_SESSION["usuario_id"])){
  header("../legajos/login/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
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
  <!-- /////// dar de baja empleado ////////-->
  <?php include("includes/mdl/empleado-baja.php"); ?>
  <!-- /////// datos personales /////-->
  <?php include("includes/mdl/empleado-editar-datospersonales.php"); ?>
  <!-- /////// datos de domicilio /////-->
  <?php include("includes/mdl/empleado-editar-domicilio.php"); ?>
  <!-- /////// datos de contacto /////-->
  <?php include("includes/mdl/empleado-editar-contacto.php"); ?>

  <!-- /////// step 5 - Conyuge /////-->
  <!-- /////// dar de baja conyuge ////////-->
  <?php include("includes/mdl/conyuge-baja.php"); ?>
  <!-- /////// datos de personales conyuge /////-->
  <?php include("includes/mdl/conyuge-editar-datospersonales.php"); ?>
  <!-- /////// datos de domicilio /////-->
  <?php include("includes/mdl/conyuge-editar-domicilio.php"); ?>
  <!-- /////// datos de contacto /////-->
  <?php include("includes/mdl/conyuge-editar-contacto.php"); ?>

  <!-- /////// step 6 - Hijos /////-->
  <?php include("includes/mdl/hijo-editar.php"); ?>
  <?php include("includes/mdl/hijo-eliminar.php"); ?>
  <?php include("includes/mdl/hijo-habilitar.php");?>
  <?php include("includes/mdl/hijo-deshabilitar.php");?>
  <?php include("includes/mdl/hijo-editar-escuela.php");?>
  <?php include("includes/mdl/hijo-editar-beneficiario.php");?>
  <?php include("includes/mdl/hijo-editar-mop.php");?>
  <!--Pre-Natal-->
  <?php include("includes/mdl/prenatal-editar.php");?>
  <?php include("includes/mdl/prenatal-eliminar.php");?>
  <?php include("includes/mdl/prenatal-editar-beneficiario.php");?>
  <?php include("includes/mdl/prenatal-editar-mop.php");?>
  <?php include("includes/mdl/prenatal-habilitar.php");?>
  <?php include("includes/mdl/prenatal-deshabilitar.php");?>

  <!-- /////// ventanas modal viejas /////-->
  <?php include("includes/mdl/legajoppermanente-editar.php");?>
  <?php include("includes/mdl/legajojornalero-editar.php");?>

	<?php include("includes/mdl/estudiomodificar.php");?>
	<?php include("includes/mdl/estudioeliminar.php");?>
	<?php include("includes/mdl/fichadaagregar.php");?>
  <?php include("includes/mdl/fichadamodificar.php");?>
  <?php include("includes/mdl/fichadaeliminar.php");?>
	<?php include("includes/mdl/relojmodificar.php");?>
	<?php //include("includes/mdl/conyugeagregar.php");?>
	<?php //include("includes/mdl/prenatalmodificar.php");?>
	<?php //include("includes/mdl/prenataleliminar.php");?>

	<?php include("includes/mdl/hijoconstancia.php");?>
  <!--- no sirven fueron remplazados ---->
  <?php //include("includes/mdl/hijomodificar.php");?>
  <?php //include("includes/mdl/hijoeliminar.php");?>
  <?php //include("includes/mdl/hijoasignacionhab.php");?>

	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Empleado</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
									<li class="breadcrumb-item"><a href="index.php">Empleados</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edicion de Empleado</li>
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
        <?php
          $empleadondocto = $emp->legajo_nrodocto;
        ?>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<h4 class="text-blue"><?php echo $emp->legajo_apellido.", ".$emp->legajo_nombres ?></h4>
						<p class="mb-30 font-14">Edicion de Empleado</p>
					</div>
					<div class="wizard-content">
						<form class="tab-wizard wizard-circle wizard" id="" action="?c=empleado&a=EmpleadoPadron" method="post" enctype="multipart/form-data">
							<!-- Step 1 -->
							<h5>Datos Personales</h5>
							<section>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div align="right">
                        <button type="button"
                                class="btn btn-danger"
                                data-toggle="modal"
                                data-target="#EmpleadoBaja"
                                data-titulo="DAR DE BAJA EMPLEADO"
                                data-empid="<?php echo $emp->legajo_id; ?>"
                                data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>">
                                <!--<i class="fa fa-user-times" aria-hidden="true"></i>-->
                                <!--<i class="fi-minus-circle"></i>-->
                                <!--<i class="ion-power"></i>-->
                                <!--<i class="icon-copy fi-prohibited fa-lg"></i>-->
                                <i class="icon-copy fi-prohibited fa-lg"></i> DAR DE BAJA
                        </button>
                        <?php
                          if(empty($emp->legajo_celular) AND empty($emp->legajo_telefono) AND empty($emp->legajo_email)){
                            ?>
                            <button type="button"
                                    class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#EmpleadoEditarContacto"
                                    data-titulo="Editar Datos de Contacto"
                                    data-empid="<?php echo $emp->legajo_id; ?>"
                                    data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                    data-empcelular="<?php echo $emp->legajo_celular; ?>"
                                    data-emptelefono="<?php echo $emp->legajo_telefono; ?>"
                                    data-empemail="<?php  echo $emp->legajo_email; ?>">

                                    <!--<i class="ion-android-phone-portrait"></i>-->
                                    <!--<span class="ti-tablet"></span>-->
                                    <!--<i class="fa fa-vcard-o" aria-hidden="true"></i>-->
                                    <i class="icon-copy ion-social-whatsapp-outline fa-lg"></i> AGREGAR Datos de Contacto
                            </button>
                            <?php
                          }else{
                            //--- existen datos de contacto
                          }
                        ?>
                        <?php
                          if(empty($emp->legajo_direccion)){
                            ?>
                            <button type="button"
                                    class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#EmpleadoEditarDomicilio"
                                    data-titulo="Editar Datos de Domicilio"
                                    data-empid="<?php echo $emp->legajo_id; ?>"
                                    data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                    data-empdireccion="<?php echo $emp->legajo_direccion; ?>"
                                    data-empdirecnro="<?php echo $emp->legajo_direcnro; ?>"
                                    data-empdirecpiso="<?php echo $emp->legajo_direcpiso; ?>"
                                    data-empcpostal="<?php echo $emp->legajo_codpostal; ?>"
                                    data-emppais="<?php echo $emp->pais_id; ?>"
                                    data-empprovincia="<?php echo $emp->provincia_id; ?>"
                                    data-empdepartamento="<?php echo $emp->departamento_id; ?>"
                                    data-emplocalidad="<?php echo $emp->localidad_id; ?>">
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
                                data-empid="<?php echo $emp->legajo_id; ?>"
                                data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                data-empnrocuil="<?php echo $emp->legajo_nrocuil; ?>"
                                data-empnrolegajo="<?php echo $emp->legajo_numerop; ?>"
                                data-empapellido="<?php echo $emp->legajo_apellido; ?>"
                                data-empnombres="<?php echo $emp->legajo_nombres; ?>"
                                data-empsexo="<?php echo $emp->sexo_id; ?>"
                                data-empestadocivil="<?php echo $emp->estcivil_id; ?>"
                                data-empfecnac="<?php echo $emp->legajo_fecnacto; ?>"
                                data-empfecing="<?php echo $emp->legajo_fecingreso; ?>"
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
											$nrodocto = $emp->legajo_nrodocto;
											$legcontrato = $this->model->ObtenerContrato($nrodocto);
											?>
											<input type="hidden" name="empid" id="empid" value="<?php echo $emp->legajo_id; ?>">
											<input type="hidden" name="empnrodocumento" id="empnrodocumento" value="<?php echo $emp->legajo_nrodocto; ?>">
                      <input type="hidden" name="empppdl" id="empppdl" value="<?php echo $emp->pais_id."-".$emp->provincia_id."-".$emp->departamento_id."-".$emp->localidad_id; ?>">

											<!--<input type="hidden" name="contratoid" id="contratoid" value="<?php echo $emp->legcontrato_id; ?>">-->
											<!--<input type="hidden" name="imputacion" id="imputacion" value="<?php echo $legcontrato->imputacion_id."-".$legcontrato->impactividad_id; ?>">-->

										</div>
									</div>
								</div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-12">
    										<div class="form-group">
                          <?php
      											$img = '../../imagenes/legajos/'.$emp->legajo_imagen.'.jpg';
      											if(file_exists($img)){
      										    ?>
                              <img src="../../imagenes/legajos/<?php echo $emp->legajo_imagen; ?>.jpg" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
      										    <?php
      											}else{
          										if($emp->sexo_id == 1){
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
    											<input type="text" name="txtnrodoctom" id="txtnrodoctom" value="<?php echo $emp->legajo_nrodocto; ?>" class="form-control" disabled>
    										</div>
    									</div>
                      <div class="col-md-4">
    										<div class="form-group">
    											<label for="txtempnrocuilm">CUIL :</label>
    											<input type="text" name="txtempnrocuilm" id="txtempnrocuilm" value="<?php echo $emp->legajo_nrocuil; ?>" class="form-control" disabled>
    										</div>
    									</div>
                      <div class="col-md-4">
    										<div class="form-group">
    											<label for="txtempnrolegajom">Nro. de Legajo:</label>
    											<input type="text" name="txtempnrolegajom" id="txtempnrolegajom" value="<?php echo $emp->legajo_numerop; ?>" class="form-control" disabled>
    										</div>
    									</div>
    								</div>
                    <div class="row">
    									<div class="col-md-12">
    										<div class="form-group">
    											<label for="txtempapellidom">Apellido:</label>
    											<input type="text" name="txtempapellidom" id="txtempapellidom" value="<?php echo $emp->legajo_apellido; ?>" class="form-control" required disabled>
    										</div>
    									</div>
    								</div>
                    <div class="row">
                      <div class="col-md-12">
    										<div class="form-group">
    											<label for="txtempnombresm">Nombres:</label>
    											<input type="text" name="txtempnombresm" id="txtempnombresm" value="<?php echo $emp->legajo_nombres; ?>" class="form-control" disabled>
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
    															<option value="<?php echo $row->sexo_id; ?>"<?php if (!(strcmp($row->sexo_id, $emp->sexo_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->sexo_nombre; ?></option>
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
    															<option value="<?php echo $row->estcivil_id; ?>"<?php if (!(strcmp($row->estcivil_id, $emp->estcivil_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->estcivil_nombre; ?></option>
    												<?php endforeach; ?>
    											</select>
    										</div>
    									</div>
                    </div>
                    <div class="row">
    									<div class="col-md-6">
    										<div class="form-group">
    											<label for="cboempestadocivilm">Fecha de Nacimiento:</label>
    											<input type="date" name="cboempestadocivilm" id="cboempestadocivilm" class="form-control" value="<?php echo $emp->legajo_fecnacto; ?>" placeholder="Select Date" disabled>
    										</div>
    									</div>
    									<div class="col-md-6">
    										<div class="form-group">
                          <label for="txtempfecingm">Fecha de Ingreso:</label>
                          <input type="date" name="txtempfecingm" id="txtempfecingm" value="<?php echo $emp->legajo_fecingreso; ?>" class="form-control" disabled>
    										</div>
    									</div>
    								</div>
                  </div>
                </div>
                <!--//////////Final formulario empleado - datos personales///////// -->
                <?php
                  if(empty($emp->legajo_direccion)){
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
                                    data-empid="<?php echo $emp->legajo_id; ?>"
                                    data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                    data-empdireccion="<?php echo $emp->legajo_direccion; ?>"
                                    data-empdirecnro="<?php echo $emp->legajo_direcnro; ?>"
                                    data-empdirecpiso="<?php echo $emp->legajo_direcpiso; ?>"
                                    data-empcpostal="<?php echo $emp->legajo_codpostal; ?>"
                                    data-emppais="<?php echo $emp->pais_id; ?>"
                                    data-empprovincia="<?php echo $emp->provincia_id; ?>"
                                    data-empdepartamento="<?php echo $emp->departamento_id; ?>"
                                    data-emplocalidad="<?php echo $emp->localidad_id; ?>">
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
    											<input type="text" name="txtempdireccionm" id="txtempdireccionm" value="<?php echo $emp->legajo_direccion; ?>" class="form-control" disabled>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="txtempdirenrom">Numero:</label>
    											<input type="text" name="txtempdirenrom" id="txtempdirenrom" value="<?php echo $emp->legajo_direcnro; ?>" class="form-control" disabled>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="txtempdirecpisom">Piso:</label>
    											<input type="text" name="txtempdirecpisom" id="txtempdirecpisom" value="<?php echo $emp->legajo_direcpiso; ?>" class="form-control" disabled>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="txtempcpostalm">Codigo Postal:</label>
    											<input type="text" name="txtempcpostalm" id="txtempcpostalm" value="<?php echo $emp->legajo_codpostal; ?>" class="form-control" disabled>
    										</div>
    									</div>
                      <div class="col-md-3">
    										<div class="form-group">
    											<label for="cboemppaism">Pais:</label>
    											<select name="cboemppaism" id="cboemppaism" class="custom-select form-control" disabled>
    												<option></option>
    													<?php foreach($this->model->Paises() as $row): ?>
    															<option value="<?php echo $row->pais_id; ?>"<?php if (!(strcmp($row->pais_id, $emp->pais_id))) {echo "selected=\"selected\"";} ?>><?php echo $row->pais_nombre; ?></option>
    												<?php endforeach; ?>
    											</select>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="cboempprovinciam">Provincia:</label>
    											<select name="cboempprovinciam" id="cboempprovinciam" class="custom-select form-control" disabled>
    												<option value=""></option>
    											</select>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="cboempdepartamentom">Departamento:</label>
    											<select name="cboempdepartamentom" id="cboempdepartamentom" class="custom-select form-control" disabled>
    												<option></option>
    											</select>
    										</div>
    									</div>
    									<div class="col-md-3">
    										<div class="form-group">
    											<label for="cboemplocalidadm">Localidad:</label>
    											<select name="cboemplocalidadm" id="cboemplocalidadm" class="custom-select form-control" disabled>
    												<option></option>
    											</select>
    										</div>
    									</div>
    								</div>
                    <?php
                  }
                ?>
                <!--//////////Final formulario empleado - datos de domicilio///////// -->
                <?php
                  if(empty($emp->legajo_celular) AND empty($emp->legajo_telefono) AND empty($emp->legajo_email)){
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
                                    data-empid="<?php echo $emp->legajo_id; ?>"
                                    data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                    data-empcelular="<?php echo $emp->legajo_celular; ?>"
                                    data-emptelefono="<?php echo $emp->legajo_telefono; ?>"
                                    data-empemail="<?php  echo $emp->legajo_email; ?>">
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
                          <input type="number" name="txtempcelularm" id="txtempcelularm" value="<?php echo $emp->legajo_celular; ?>" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="txtemptelefonom">Telefono :</label>
                          <input type="number" name="txtemptelefonom" id="txtemptelefonom" value="<?php echo $emp->legajo_telefono; ?>" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="txtempemailm">Email:</label>
                          <input type="email" name="txtempemailm" id="txtempemailm" class="form-control" value="<?php echo $emp->legajo_email; ?>" disabled>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                ?>
							</section>
							<!-- Step 2 -->

							<!-- Step 3 -->

							<!-- Step 4 -->

							<!-- Step 5 -->

							<!-- Step 6 -->
							<h5>Hijos</h5>
							<section>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<div align="right">

												<button type="button" class="btn btn-info view_data" data-toggle="modal" data-target="#dataConstanciaHijo" data-id="<?php echo $emp->legajo_nrodocto; ?>">Constancias ESCOLARES</button>

                        <!-- boton agregar prenatal-->
												<button type="button"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#dataUpdatePreNatal"
                                data-titulo="<?php echo "Nuevo Pre-Natal"; ?>"
                                data-empid="<?php echo $emp->legajo_id; ?>"
                                data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                data-bennrodocto="<?php echo $emp->legajo_nrodocto; ?>">
                                AGREGAR Pre-Natal
                        </button>
                        <!-- boton agregar hijo -->
												<button type="button"
                                class="btn btn-success"
                                data-toggle="modal"
                                data-target="#dataUpdateHijo"
                                data-titulo="<?php echo "Agregar nuevo hijo"; ?>"
                                data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                data-empid="<?php echo $emp->legajo_id; ?>"
                                data-bennrodocto="<?php echo $emp->legajo_nrodocto; ?>">
                                AGREGAR Hijo
                        </button>
											</div>
										</div>
									</div>
									<!-- PRE-NATAL -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$empleadonrodocto = $emp->legajo_nrodocto;
												$prenatal = $this->model->ObtenerPreNatal($empleadonrodocto);
												$prenatalc = count($prenatal);
												if($prenatalc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-blue">
                              <label>
                                Pre-Natal/es
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $prenatalc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">FUM</th>
																<th scope="col">FPP</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($prenatal as $row):
															?>
															<tr>
																<?php
																	$fum = date("d/m/Y", strtotime($row->legprenatal_fecum));
																	$fpp = date("d/m/Y", strtotime($row->legprenatal_fecpp));
																?>
																<td><?php echo $fum; ?></td>
																<td><?php echo $fpp; ?></td>
																<td>
																	<?php echo $row->legprenatal_benndoc." - ".$row->legprenatal_benapellido.", ".$row->legprenatal_bennombres; ?>
																</td>

                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdatePreNatal"
                                         data-titulo="<?php echo "Editar Pre-Natal: "; ?>"
                                         data-prenid="<?php echo $row->legprenatal_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $row->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->legprenatal_benndoc; ?>"
                                         data-prenatalfecum="<?php echo $row->legprenatal_fecum; ?>"
                                         data-prenatalfecpp="<?php echo $row->legprenatal_fecpp; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar Pre-Natal</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeletePreNatal"
                                         data-prenid="<?php echo $row->legprenatal_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->legprenatal_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar Pre-Natal</em>
              		                    </a>


                                      <?php
                                        if($row->legajo_nrodocto == $row->legprenatal_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioPreNatal"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-prenid="<?php echo $row->legprenatal_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->legprenatal_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioPreNatal"
                                             data-titulo="<?php echo "Editar otro beneficiario"; ?>"
                                             data-prenid="<?php echo $row->legprenatal_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->legprenatal_benndoc; ?>"
                                             data-prenbenndoc="<?php echo $row->legprenatal_benndoc; ?>"
                                             data-prenbennoficio="<?php echo $row->legprenatal_bennoficio; ?>"
                                             data-prenbenapellido="<?php echo $row->legprenatal_benapellido; ?>"
                                             data-prenbennombres="<?php echo $row->legprenatal_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->legprenatal_madrendoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de la madre"
                                             data-target="#UpdatemopPreNatal"
                                             data-titulo="<?php echo "Editar datos de la madre"; ?>"
                                             data-prenmopid="<?php echo $row->legprenatal_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-prenmopndoc="<?php echo $row->legprenatal_madrendoc; ?>"
                                             data-prenmopapellido="<?php echo $row->legprenatal_madreapellido; ?>"
                                             data-prenmopnombres="<?php echo $row->legprenatal_madrenombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos del Padre"
                                             data-target="#UpdatemopPreNatal"
                                             data-titulo="<?php echo "Editar datos del padre"; ?>"
                                             data-prenmopid="<?php echo $row->legprenatal_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-prenmopndoc="<?php echo $row->legprenatal_madrendoc; ?>"
                                             data-prenmopapellido="<?php echo $row->legprenatal_madreapellido; ?>"
                                             data-prenmopnombres="<?php echo $row->legprenatal_madrenombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar datos de la madre"
                                             data-target="#UpdatemopPreNatal"
                                             data-titulo="<?php echo "Agregar datos de la madre"; ?>"
                                             data-prenmopid="<?php echo $row->legprenatal_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar datos del padre"
                                             data-target="#UpdatemopPreNatal"
                                             data-titulo="<?php echo "Agregar datos del padre"; ?>"
                                             data-prenmopid="<?php echo $row->legprenatal_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Pre-Natal"
                                         data-target="#dataDisablePreNatal"
                                         data-titulo="<?php echo "Deshabilitar Pre-Natal"; ?>"
                                         data-prenid="<?php echo $row->legprenatal_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->legprenatal_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Pre-Natal -----
												}
											?>
										</div>
									</div>
									<!-- HIJOS MENORES -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$empleadonrodocto = $emp->legajo_nrodocto;
												$fechaactual = date("Y-m-d");
				                //resto 5 años
                        $fechafinal = date("Y-m-d",strtotime($fechaactual."- 6 year"));//resto 5 años
        				        //$fechafinal = date("Y-m-d",strtotime($fechafinaluno."- 1 month"));

												$hijosmenores = $this->model->ObtenerHijosMenores($empleadonrodocto, $fechaactual, $fechafinal);
												$hijosmenoresc = count($hijosmenores);
												if($hijosmenoresc > 0){
													?>
													<div class="clearfix">
														<h5 class="text-blue">
                              <label>
                                Hijo/s menor/es
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $hijosmenoresc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>


													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">EDAD</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($hijosmenores as $row):
																//$hijodireccion = $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id;
															?>
															<tr>
																<td>
																	<?php	echo $row->leghijo_nrodocto; ?>
																</td>
																<td>
																	<?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?>
																</td>
																<td>
																	<?php
																	$fechanacimiento = $row->leghijo_fecnacto;
																	$edad = $this->model->CalculaEdad($fechanacimiento);
                                  if($edad > 0){
																	  echo $edad;
                                  }else{
                                    echo "*";
                                  }
																	?>
																</td>
																<td>
																	<?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?>
																</td>
																<td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Agregar datos escolares</em>
              		                    </a>


                                      <?php
                                        if($row->legajo_nrodocto == $row->leghijo_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                             data-hbenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                             data-hbennombres="<?php echo $row->leghijo_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->leghijo_mopndoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Asignacion"
                                         data-target="#dataDisableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos menores
												}
											?>
										</div>
									</div>
									<!-- HIJO PRE-ESCOLAR -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$escuelanivel = 1;
												$hijospreescolar = $this->model->ObtenerHijosEscolares($empleadonrodocto, $escuelanivel);
												$hijospreescolarc = count($hijospreescolar);
												if($hijospreescolarc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-blue">
                              <label>
                                Hijo/s Pre-Escolar/es
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $hijospreescolarc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">ESCUELA</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($hijospreescolar as $row):
															?>
															<tr>
																<td><?php	echo $row->leghijo_nrodocto; ?></td>
																<td><?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?></td>
																<td><?php echo $row->escuela_nombre; ?></td>
																<td><?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?></td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hescid="<?php echo $row->escuela_id; ?>"
                                         data-hescnvl="<?php echo $row->escnivel_id; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Editar datos escolares</em>
              		                    </a>


                                      <?php
                                        if($row->legajo_nrodocto == $row->leghijo_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                             data-hbenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                             data-hbennombres="<?php echo $row->leghijo_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->leghijo_mopndoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Asignacion"
                                         data-target="#dataDisableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>

																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos en escuela pre-escolar
												}
											?>
										</div>
									</div>
									<!-- HIJO EN ESCUELA PRIMARIA -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$escuelanivel = 2;
												$hijospreescolar = $this->model->ObtenerHijosEscolares($empleadonrodocto, $escuelanivel);
												$hijospreescolarc = count($hijospreescolar);
												if($hijospreescolarc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-blue">
                              <label>
                                Hijo/s en Escuela Primaria
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $hijospreescolarc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">ESCUELA</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																//$nrodocto = $emp->legajo_nrodocto;
																foreach($hijospreescolar as $row):
															?>
															<tr>
																<td>
																	<?php	echo $row->leghijo_nrodocto; ?>
																</td>
																<td>
																	<?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?>
																</td>
																<td>
																	<?php echo $row->escuela_nombre;	?>
																</td>
																<td>
																	<?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?>
																</td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hescid="<?php echo $row->escuela_id; ?>"
                                         data-hescnvl="<?php echo $row->escnivel_id; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Editar datos escolares</em>
              		                    </a>


                                      <?php
                                        if($row->legajo_nrodocto == $row->leghijo_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                             data-hbenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                             data-hbennombres="<?php echo $row->leghijo_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->leghijo_mopndoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Asignacion"
                                         data-target="#dataDisableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos en escuela primaria
												}
											?>
										</div>
									</div>
									<!-- HIJOS EN ESCUELA SECUNDARIA Y SUPERIOR -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$escuelanivel = 3;
												$hijospreescolar = $this->model->ObtenerHijosEscolares($empleadonrodocto, $escuelanivel);
												$hijospreescolarc = count($hijospreescolar);
												if($hijospreescolarc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-blue">
                              <label>
                                Hijo/s en Escuela Secunadria y Superior
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $hijospreescolarc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">ESCUELA</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($hijospreescolar as $row):
															?>
															<tr>
																<td>
																	<?php	echo $row->leghijo_nrodocto; ?>
																</td>
																<td>
																	<?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?>
																</td>
																<td>
																	<?php echo $row->escuela_nombre;	?>
																</td>
																<td>
																	<?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?>
																</td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hescid="<?php echo $row->escuela_id; ?>"
                                         data-hescnvl="<?php echo $row->escnivel_id; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Editar datos escolares</em>
              		                    </a>


                                      <?php
                                        if($row->legajo_nrodocto == $row->leghijo_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                             data-hbenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                             data-hbennombres="<?php echo $row->leghijo_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->leghijo_mopndoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Asignacion"
                                         data-target="#dataDisableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos en escuela secundaria y superior ----
												}
											?>
										</div>
									</div>
									<!-- HIJOS CON DISCAPACIDAD -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$hijosconcapacidadesdiferentes = $this->model->ObtenerHijosConCapacidadesDiferentes($empleadonrodocto);
												$hijosconcapacidadesdiferentesc = count($hijosconcapacidadesdiferentes);
												if($hijosconcapacidadesdiferentesc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-blue">
                              <label>
                                Hijo/s con Discapacidad
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $hijosconcapacidadesdiferentesc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">EDAD</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																//$nrodocto = $emp->legajo_nrodocto;
																foreach($hijosconcapacidadesdiferentes as $row):
															?>
															<tr>
																<td>
																	<?php	echo $row->leghijo_nrodocto; ?>
																</td>
																<td>
																	<?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?>
																</td>
																<td>
                                  <?php
																	$fechanacimiento = $row->leghijo_fecnacto;
																	$edad = $this->model->CalculaEdad($fechanacimiento);
                                  if($edad > 0){
																	  echo $edad;
                                  }else{
                                    echo "*";
                                  }
																	?>
                                </td>
																<td>
																	<?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?>
																</td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Agregar datos escolares</em>
              		                    </a>


                                      <?php
                                        if($row->legajo_nrodocto == $row->leghijo_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                             data-hbenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                             data-hbennombres="<?php echo $row->leghijo_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->leghijo_mopndoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Asignacion"
                                         data-target="#dataDisableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos con discapacidad
												}
											?>
										</div>
									</div>
									<!-- HIJOS ESCOLARES CON DISCAPACIDAD -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$hijosescconcapacidadesdiferentes= $this->model->ObtenerHijosEscConCapacidadesDiferentes($empleadonrodocto);
												$hijosescconcapacidadesdiferentesc = count($hijosescconcapacidadesdiferentes);
												if($hijosescconcapacidadesdiferentesc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-blue">
                              <label>
                                Hijo/s escolares con Discapacidad
                                <span class="badge badge-pill badge-primary">
                                  <?php echo $hijosescconcapacidadesdiferentesc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">ESCUELA</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																//$nrodocto = $emp->legajo_nrodocto;
																foreach($hijosescconcapacidadesdiferentes as $row):
															?>
															<tr>
																<td>
																	<?php	echo $row->leghijo_nrodocto; ?>
																</td>
																<td>
																	<?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?>
																</td>
																<td>
																	<?php echo $row->escuela_nombre;	?>
																</td>
																<td>
																	<?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?>
																</td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hescid="<?php echo $row->escuela_id; ?>"
                                         data-hescnvl="<?php echo $row->escnivel_id; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Editar datos escolares</em>
              		                    </a>


                                      <?php
                                        if($row->legajo_nrodocto == $row->leghijo_benndoc){
                                          //------ mismo beneficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Agregar otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Agregar otro beneficiario" ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //-----distinto beficiario
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Editar datos de otro beneficiario"
                                             data-target="#UpdateBeneficiarioHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijoid="<?php echo $row->leghijo_id; ?>"
                                             data-empid="<?php echo $emp->legajo_id; ?>"
                                             data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                             data-benndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                             data-hbennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                             data-hbenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                             data-hbennombres="<?php echo $row->leghijo_bennombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar otro beneficiario</em>
                  		                    </a>
                                          <?php
                                        }
                                      ?>
                                      <?php
                                      if($row->leghijo_mopndoc > 0){
                                        //--Existen datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>"
                                             data-hmopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                             data-hmopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                             data-hmopnombres="<?php echo $row->leghijo_mopnombres; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Editar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }else{
                                        //-- No hay datos de mop
                                        if($emp->sexo_id == 1){
                                          //empleado masculino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #00b347;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos de la madre</em>
                  		                    </a>
                                          <?php
                                        }else{
                                          //empleado femenino
                                          ?>
                                          <a href="#"
                  													 class="dropdown-item"
                  		                       data-toggle="modal"
                                             title="Deshabilitar Asignacion"
                                             data-target="#UpdatemopHijo"
                                             data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                             data-hijomopid="<?php echo $row->leghijo_id; ?>"
                                             data-empmopid="<?php echo $emp->legajo_id; ?>">
                                             <i class="ion-android-person fa-lg" style="color: #0000ff;"></i>
                  													 &nbsp;&nbsp;&nbsp;<em>Agregar datos del padre</em>
                  		                    </a>
                                          <?php
                                        }
                                      }
                                      ?>
                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Deshabilitar Asignacion"
                                         data-target="#dataDisableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-off" ></i>
                                         &nbsp;&nbsp;&nbsp;<em>Deshabilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos escolares con discapacidad
												}
											?>
										</div>
									</div>
                  <!-- HIJO CON ASIGNACION DESHABILITADA -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												//$escuelanivel = 1;
												$hijosasignaciondes = $this->model->ObtenerHijosAsignacionDeshabilitada($empleadonrodocto);
												$hijosasignaciondesc = count($hijosasignaciondes);
												if($hijosasignaciondesc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-danger">
                              <label>
                                Hijo/s con Asignacion Deshabilitada
                                <span class="badge badge-pill badge-danger">
                                  <?php echo $hijosasignaciondesc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">ESCUELA</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																//$nrodocto = $emp->legajo_nrodocto;
																foreach($hijosasignaciondes as $row):
															?>
															<tr>
																<td><?php	echo $row->leghijo_nrodocto; ?></td>
																<td><?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?></td>
																<td>
                                  <?php
                                    if($row->leghijo_esc == 1){
                                      //escolar
                                      //echo $row->escuela_nombre;
                                      echo "*";
                                    }else{
                                      //no escolar
                                      echo "*";
                                    }
                                  ?>
                                </td>

																<td><?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?></td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>

                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Habilitar Asignacion"
                                         data-target="#dataEnableHijo"
                                         data-titulo="<?php echo "Hijo: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="fa fa-toggle-on" style="color: #00b347;"></i>
                                         &nbsp;&nbsp;&nbsp;<em>Habilitar asignacion</em>
                                      </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos en escuela pre-escolar
												}
											?>
										</div>
									</div>
                  <!-- Pre-Natal CON ASIGNACION DESHABILITADA -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												//$escuelanivel = 1;
												$prenatalasignaciondes = $this->model->ObtenerPreNatalAsignacionDeshabilitada($empleadonrodocto);
												$prenatalasignaciondesc = count($prenatalasignaciondes);
												if($prenatalasignaciondesc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-danger">
                              <label>
                                Pre-Natal/s con Asignacion Deshabilitada
                                <span class="badge badge-pill badge-danger">
                                  <?php echo $prenatalasignaciondesc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
                              <tr>
																<th scope="col">FUM</th>
																<th scope="col">FPP</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																//$nrodocto = $emp->legajo_nrodocto;
																foreach($prenatalasignaciondes as $row):
                                  $fum = date("d/m/Y", strtotime($row->legprenatal_fecum));
																	$fpp = date("d/m/Y", strtotime($row->legprenatal_fecpp));
															?>
															<tr>
																<td><?php	echo $fum; ?></td>
																<td><?php echo $fpp;	?></td>
																<td>
                                  <?php echo $row->legprenatal_benndoc." - ".$row->legprenatal_benapellido.", ".$row->legprenatal_bennombres; ?>
                                </td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeletePreNatal"
                                         data-prenid="<?php echo $row->legprenatal_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->legprenatal_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar Pre-Natal</em>
              		                    </a>

                                      <a href="#"
                                         class="dropdown-item"
                                         data-toggle="modal"
                                         title="Habilitar Pre-Natal"
                                         data-target="#dataEnablePreNatal"
                                         data-titulo="<?php echo "Habilitar Pre-Natal"; ?>"
                                         data-prenid="<?php echo $row->legprenatal_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->legprenatal_benndoc; ?>">
                                         <i class="fa fa-toggle-on" style="color: #00b347;"></i>
                                         &nbsp;&nbsp;&nbsp;<em>Habilitar asignacion</em>
                                      </a>

              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos en escuela pre-escolar
												}
											?>
										</div>
									</div>
									<!-- HIJOS SIN ASIGNACION -->
									<div class="col-md-12">
										<div class="form-group">
											<?php
												$hijossinasignacion = $this->model->ObtenerHijosSinAsignacion($empleadonrodocto, $fechaactual, $fechafinal);
												$hijossinasignacionc = count($hijossinasignacion);
												if($hijossinasignacionc > 0){
													?>
													<div class="clearfix">
                            <h5 class="text-danger">
                              <label>
                                Hijo/s sin asignacion/es
                                <span class="badge badge-pill badge-danger">
                                  <?php echo $hijossinasignacionc; ?>
                                </span>
                              </label>
                            </h5>
														<p></p>
													</div>
													<table class="resp2">
														<thead>
															<tr>
																<th scope="col">DNI</th>
																<th scope="col">APELLIDO Y NOMBRES</th>
																<th scope="col">EDAD</th>
																<th scope="col">BENEFICIARIO</th>
																<th width="18%" scope="col">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<?php
																foreach($hijossinasignacion as $row):
															?>
															<tr>
																<td>
																	<?php	echo $row->leghijo_nrodocto; ?>
																</td>
																<td>
																	<?php echo $row->leghijo_apellido.", ".$row->leghijo_nombres;	?>
																</td>
																<td>
                                </td>
																<td>
																	<?php echo $row->leghijo_benndoc." - ".$row->leghijo_benapellido.", ".$row->leghijo_bennombres; ?>
																</td>
                                <td style="text-align: right;">
                                  <div class="dropdown">
              											<a class="btn btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown">
              												Opciones
              											</a>
              											<div class="dropdown-menu dropdown-menu-right">

                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataViewHijo"
              		                       data-titulo="<?php echo ""; ?>">
                                         <i class="fa fa-eye" style="color: #00b347;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Ver detalles</em>
              		                    </a>

              												<a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataUpdateHijo"
                                         data-titulo="<?php echo "Edicion: ".$row->leghijo_apellido.", ".$row->leghijo_nombres; ?>"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-hijotdoc="<?php echo $row->leghijo_tipodocto; ?>"
                                         data-hijondoc="<?php echo $row->leghijo_nrodocto; ?>"
                                         data-hijoapellido="<?php echo $row->leghijo_apellido; ?>"
                                         data-hijonombres="<?php echo $row->leghijo_nombres; ?>"
                                         data-hijonrocuil="<?php echo $row->leghijo_nrocuil; ?>"
                                         data-hijosexo="<?php echo $row->sexo_id; ?>"
                                         data-hijofecnacto="<?php echo $row->leghijo_fecnacto; ?>"
                                         data-hijodireccion="<?php echo $row->leghijo_direccion; ?>"
                                         data-hijodirecnro="<?php echo $row->leghijo_direcnro; ?>"
                                         data-hijodirecpiso="<?php echo $row->leghijo_direcpiso; ?>"
                                         data-hijocodpostal="<?php echo $row->leghijo_codpostal; ?>"
                                         data-hijoppdl="<?php echo $row->pais_id."-".$row->provincia_id."-".$row->departamento_id."-".$row->localidad_id; ?>"
                                         data-hijopais="<?php echo $row->pais_id; ?>"
                                         data-hijoprovincia="<?php echo $row->provincia_id; ?>"
                                         data-hijodepartamento="<?php echo $row->departamento_id; ?>"
                                         data-hijolocalidad="<?php echo $row->localidad_id; ?>"
                                         data-hijodisc="<?php echo $row->leghijo_disc; ?>"
                                         data-hijoesc="<?php echo $row->leghijo_esc; ?>"
                                         data-hijoescnom="<?php echo $row->escuela_id; ?>"
                                         data-hijoescnvl="<?php echo $row->escnivel_id; ?>"
                                         data-hijoescest="<?php echo $row->escestado_id; ?>"
                                         data-hijomoptdoc="<?php echo $row->leghijo_moptdoc; ?>"
                                         data-hijomopndoc="<?php echo $row->leghijo_mopndoc; ?>"
                                         data-hijomopapellido="<?php echo $row->leghijo_mopapellido; ?>"
                                         data-hijomopnombres="<?php echo $row->leghijo_mopnombres; ?>"
                                         data-hijobentdoc="<?php echo $row->leghijo_bentdoc; ?>"
                                         data-hijobennoficio="<?php echo $row->leghijo_bennoficio; ?>"
                                         data-hijobenndoc="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hijobenapellido="<?php echo $row->leghijo_benapellido; ?>"
                                         data-hijobennombres="<?php echo $row->leghijo_bennombres; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-compose fa-lg" style="color: #0000ff;"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Editar hijo</em>
              		                    </a>
                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
              		                       data-target="#dataUpdateEscuelaHijo"
              		                       data-titulo="<?php echo "Agregar Escuela"; ?>"
                                         data-hijoid="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empnrodocto="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-bennrodocto="<?php echo $row->leghijo_benndoc; ?>"
                                         data-hescid="<?php echo $row->escuela_id; ?>"
                                         data-hescnvl="<?php echo $row->escnivel_id; ?>">
                                         <span class="ti-home" style="color: #00b347;"></span>
              													 &nbsp;&nbsp;&nbsp;<em>Editar datos escolares</em>
              		                    </a>
                                      <a href="#"
              													 class="dropdown-item"
              		                       data-toggle="modal"
                                         data-target="#dataDeleteHijo"
                                         data-id="<?php echo $row->leghijo_id; ?>"
                                         data-empid="<?php echo $emp->legajo_id; ?>"
                                         data-empndoc="<?php echo $emp->legajo_nrodocto; ?>"
                                         data-benndoc="<?php echo $row->leghijo_benndoc; ?>">
                                         <i class="ion-android-delete fa-lg" style="color: #FF0000"></i>
              													 &nbsp;&nbsp;&nbsp;<em>Eliminar hijo</em>
              		                    </a>
              											</div>
              										</div>
																</td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													<?php
												}else{
													//---- No tiene Hijos menores
												}
											?>
										</div>
									</div>
								</div>
                <br><br>
                <br><br>
                <br><br>
                <br><br>
							</section>
						</form>
					</div>
				</div>
				<!-- success Popup html Start -->

				<!-- success Popup html End -->
			</div>
			<?php include('../../includes/footer.php'); ?>
		</div>
	</div>
	<?php include('../../includes/script.php'); ?>
	<script src="../../src/plugins/jquery-steps/build/jquery.steps.js"></script>
  <script src="includes/js/empleado-editar.js"></script>
	<!--<script src="includes/js/empleadoseditar.js"></script>-->
	<script src="includes/js/contrato.js"></script>
	<script src="includes/js/estudios.js"></script>
	<script src="includes/js/relojes.js"></script>
	<!--<script src="includes/js/conyuge.js"></script>-->
	<script src="includes/js/prenatal.js"></script>
	<script src="includes/js/hijos.js"></script>

  <!--<script src="../../src/plugins/bootstrap-select/dist/js/bootstrap-select.min.js"></script>-->
  <!--<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>-->


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
				startIndex: <?php echo $_REQUEST['startIndex']; ?>,
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
