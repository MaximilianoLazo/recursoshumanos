<?php
include('conectar.php');
session_start();
$timeoutseconds = 1; 
$timestamp = time(); 
$timeout = $timestamp-$timeoutseconds; 
mysql_query("delete from online where tiempo < $timeout") ;
$e=mysql_query("SELECT * FROM online WHERE email='".$_SESSION['usuario']."'");
$nuser=mysql_num_rows($e);
$a=mysql_fetch_assoc($e);
if($nuser!=0){
    mysql_query("UPDATE online set tiempo=$timestamp WHERE email='".$_SESSION['usuario']."'") ;
}else{
    $insert = "INSERT INTO online VALUES (NULL,'".$_SESSION['usuario']."',$timestamp)"; 
    $r1=mysql_query($insert);
}

$delete = "DELETE FROM online WHERE tiempo<$timeout"; 
$r1=mysql_query($delete);
$query="SELECT * FROM online, usuario WHERE online.email=usuario.email";
$ejecutar=mysql_query($query);
$numfilas=mysql_num_rows($ejecutar);
$array=mysql_fetch_assoc($ejecutar);

        if($numfilas>0){

            echo "<section><h1>".$numfilas."</h1><br>";
        do{
        echo "<img src='archivo/".$array['fotografia']."'><br>"
        .$array['nombre']."<br><br>";  
        }while($array=mysql_fetch_assoc($ejecutar));
        echo "</section>";
    }else{
        echo "<section>";
        echo "<h1>No hay usuarios Online</h1>"; 
        echo "</section>";
    }
    ?>