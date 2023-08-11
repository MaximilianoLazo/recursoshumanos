<?php
session_start();
if(!isset($_SESSION['usuario'])){
	header("Location:index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>usuarios Online</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/estilo.css">
	<script stype="text/javascript" src="js/online.js"></script>
</head>
 <header>
    <ul>
      <li> <a href="profe.php" id="menu">Menu</a></li>
      <li> <a href="profe.php?cerrar=ok" id="menu">Salir</a></li>
    </ul>
    </header>
<body>	 
	<center><h1>Usuarios Online</h1></center>
        <div id="online">
			<script type="text/javascript">
				refresca();
			</script>
		</div>
	
</body>
</html>