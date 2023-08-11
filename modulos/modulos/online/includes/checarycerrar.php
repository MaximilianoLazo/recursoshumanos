<?php

include('conectar.php');
$query="SELECT * FROM usuario WHERE email='".$_SESSION['usuario']."'";
$ejecutar=mysql_query($query);
$numfilas=mysql_num_rows($ejecutar);
$array=mysql_fetch_assoc($ejecutar);
if($array['tipo']==2){
	
}
if(isset($_REQUEST['cerrar']) && $_REQUEST['cerrar']=="ok"){
	session_destroy();
	header("Location: index.php");
}

if(!$_SESSION['usuario']){
header("Location: index.php");	
}

?>