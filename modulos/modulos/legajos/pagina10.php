<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

<?php
require("rutinas.php");
$t=new NumerosALetras();

for($f=1;$f<=24;$f++)
{
  $ale=rand(1,99999999999);
  echo $ale.' : '.$t->traducir($ale);
  echo '<br>';
  echo '<br>';
}
?>

</body>
</html> 
