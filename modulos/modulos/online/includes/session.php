	<?php
	include('conectar.php');
	if(isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])){
		$query="SELECT * FROM usuario WHERE email='".$_SESSION['usuario']."'";
		$us=mysql_query($query);
		$numfilas=mysql_num_rows($us);
		if($numfilas==1){
			$array=mysql_fetch_array($us);
			echo "<img src='archivo/".$array['fotografia']."' ><br>";
			echo "<span id='nombre'>".$array['nombre']."</span>";
		}else{
			echo "<center>Error</center>";
		}
	}
?>