<?php
$BD="online";
$SERVER="localhost";
$USER="root";
$PASS="CraM4sWe";
$conexion=mysql_connect($SERVER,$USER,$PASS)or die(mysql_error());
mysql_select_db($BD);

?>