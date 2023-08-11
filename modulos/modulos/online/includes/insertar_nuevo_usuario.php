<?php
 	include('conectar.php');
	$nombrefoto=$_REQUEST['fotos'];
	$email=$_REQUEST['email'];
	$pass=md5($_REQUEST['password']);
	$nom=$_REQUEST['nombre'];
	$ap=$_REQUEST['ap'];
	$tipo=$_REQUEST['tipo'];	
	$query="SELECT * FROM usuario WHERE email='".$email."'";
	$checasiesta=mysql_query($query);
	$numfilas=mysql_num_rows($checasiesta);
	if($numfilas==0){
		$insertar="INSERT INTO usuario VALUES('$email','$pass','$nom','$ap','$nombrefoto',$tipo)";
		$ejecutar=mysql_query($insertar);
		echo "El Registro ha sido exitoso<script type='text/javascript'>
			setTimeout('document.location.reload()',1000);</script>";
	}else{
		echo "No se encuentra disponible el email: ".$email." utiliza otro";
	}

?>