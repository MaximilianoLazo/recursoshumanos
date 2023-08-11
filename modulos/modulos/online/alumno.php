<?php
session_start();
include('includes/conectar.php');
if(!isset($_SESSION['usuario'])){
	header("Location:index.php");
}
include('includes/checarycerrar.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Alumno</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<script stype="text/javascript" src="js/online.js"></script>
	<script type="text/javascript">
			setInterval(refresca, 1000);
	</script>
</head>
<body>
  	<section>
    	<?php include('includes/session.php'); ?>
  	</section>
	<center> <nav>
		<ul>
			<li><a href="profe.php?cerrar=ok" id="menu">Salir</a></li>
		</ul>
	</nav></center>
	<footer>
		<div id="pie">skriom 2015</div>
	</footer>
</body>
</html>