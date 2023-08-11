<?php
include('conectar.php');
session_start();

if(isset($_POST['email']) && isset($_POST['password'])){
	$email=$_POST['email'];
	$pass=md5($_POST['password']);
	$query="SELECT * FROM usuario WHERE email='".$email."' AND password='".$pass."'";
	$ver=mysql_query($query);
	$siesta=mysql_num_rows($ver);
	if($siesta==1){
		$array=mysql_fetch_assoc($ver);
		if($array['tipo']==1){
			$_SESSION['usuario']=$email;
			echo '<meta http-equiv="REFRESH" content="0;url=alumno.php">';
		}else if($array['tipo']==2){
			$_SESSION['usuario']=$email;
			echo '<meta http-equiv="REFRESH" content="0;url=profe.php">';
		}
	}else{
		echo "Usuario o contraseña incorrecta";

	}
}
?>