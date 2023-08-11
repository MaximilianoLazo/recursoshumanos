<?php
session_start();
if(!isset($_SESSION['usuario'])){
	header("Location:index.php");
}

include('includes/checarycerrar.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Administrador</title>
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<script stype="text/javascript" src="js/online.js"></script>
	<script type="text/javascript">
				refresca();
	</script>
</head>
<body>
<section>
	<?php include('includes/session.php'); ?>
</section>
<header>	
	<nav>
	<h1>Gesti&oacuten</h1>
		<ul>
			<li><a href="online.php">Online</a></li><br>
			<li><a href='profe.php?cerrar=ok'>Salir</a></li>
		</ul>
	</nav>
</header>

<footer>
	<div id="pie">skriom 2015</div>
</footer>
</body>
</html>