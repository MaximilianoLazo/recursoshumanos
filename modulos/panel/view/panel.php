<!DOCTYPE html>
<html>

<head>

  <?php include('../../includes/head.php'); ?>
  <link href="includes/css/tabla-car.css" rel="stylesheet">

</head>

<body>
  <?php include('../../includes/header.php'); ?>
  <?php include('../../includes/sidebar.php'); ?>
  <!--**********ventanas modal***********-->

  <div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Inicio</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item active"><a href="index.php">Inicio</a></li>
								</ol>
							</nav>
						</div>
						<div class="col-md-6 col-sm-12 text-right">
							<!--<div class="dropdown">
								<a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									January 2018
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="#">Export List</a>
									<a class="dropdown-item" href="#">Policies</a>
									<a class="dropdown-item" href="#">View Assets</a>
								</div>
							</div>-->
              <?php
              //$destinodatos = $this->model->DestinoObtener($_SESSION["destino_id"]);
              ?>
             
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix mb-20">
						<!--<div class="pull-left">
							<h5 class="text-blue">Bienvenidos al nuevo Sistema de Expedientes!!!</h5>
              <h5 class="text-blue"><?php //echo $_SESSION['usuario_tipo_id']; ?></h5>

						</div>-->
					</div>
					
          <div class="row">
						<div class="col-md-12">
              <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Atención!</h4>
                <p>Colocar mensaje:</p>
                <hr>
                <!--<p class="mb-0">
                  &#8226;&nbsp;&nbsp;Documentación<br>
                  &#8226;&nbsp;&nbsp;Notas<br>
                  &#8226;&nbsp;&nbsp;Tareas<br>
                </p>
                -->
              </div>
						</div>
				  </div>
          <!--
          <div class="row">
						<div class="col-md-12">
              <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Atención!</h4>
                <p>A partir del dia 31/08/2021 se podran agregar al expediente las siguientes funciones:</p>
                <hr>
                <p class="mb-0">
                  &#8226;&nbsp;&nbsp;Documentación<br>
                  &#8226;&nbsp;&nbsp;Notas<br>
                  &#8226;&nbsp;&nbsp;Tareas<br>
                </p>
              </div>
						</div>
				  </div>
          <div class="row">
						<div class="col-md-12">
              <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Atención!</h4>
                <p>A partir del dia 31/08/2021 se podran agregar al expediente las siguientes funciones:</p>
                <hr>
                <p class="mb-0">
                  &#8226;&nbsp;&nbsp;Documentación<br>
                  &#8226;&nbsp;&nbsp;Notas<br>
                  &#8226;&nbsp;&nbsp;Tareas<br>
                </p>
              </div>
						</div>
				  </div>
          <div class="row">
						<div class="col-md-12">
              <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Atención!</h4>
                <p>A partir del dia 31/08/2021 se podran agregar al expediente las siguientes funciones:</p>
                <hr>
                <p class="mb-0">
                  &#8226;&nbsp;&nbsp;Documentación<br>
                  &#8226;&nbsp;&nbsp;Notas<br>
                  &#8226;&nbsp;&nbsp;Tareas<br>
                </p>
              </div>
						</div>
				  </div>

          <div class="row">
						<div class="col-md-12">
              <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Atención!</h4>
                <p>A partir del dia 31/08/2021 se podran agregar al expediente las siguientes funciones:</p>
                <hr>
                <p class="mb-0">
                  &#8226;&nbsp;&nbsp;Documentación<br>
                  &#8226;&nbsp;&nbsp;Notas<br>
                  &#8226;&nbsp;&nbsp;Tareas<br>
                </p>
              </div>
						</div>
				  </div>
          -->
			</div>
			<?php include('../../includes/footer.php'); ?>
		</div>
	</div>
  <?php include('../../includes/script.php'); ?>
  <script src="includes/js/legajo.js"></script>
</body>

</html>
