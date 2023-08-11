<?php

setlocale(LC_ALL,"es_ES");
setlocale(LC_TIME, 'spanish');
echo strftime("%a %d/%m/%Y", strtotime("12/28/2002"));
//echo strftime("%A %d de %B del %Y", strtotime("12/28/2002"));
//strftime("%V,%G,%Y", strtotime("12/28/2002")

//Salida: viernes 24 de febrero del 2012
?>

<?php

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

//echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
//Salida: Viernes 24 de Febrero del 2012

/*
$inicio = new DateTime('2012-06-01');
$intervalo = new DateInterval('P7D');
$fin = new DateTime('2012-08-31');
$repeticiones = 1;
$iso = 'R15/2012-06-01T00:00:00Z/P7D';

// Todos estos periodos son equivalentes.
$periodo = new DatePeriod($inicio, $intervalo, $repeticiones);
$periodo = new DatePeriod($inicio, $intervalo, $fin);
$periodo = new DatePeriod($iso);

// Al recorrer el objeto DatePeriod, se imprimen todas
// las fechas de repetición dentro del periodo.
foreach ($periodo as $fecha) {
    echo $fecha->format('Y-m-d')."\n";
}
*/
/*
$fechaInicio=strtotime("01-02-2008");
$fechaFin=strtotime("28-02-2008");
for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
    echo date("d-m-Y", $i)."<br>";
}
*/
/*
$date_start = new DateTime('2018-02-01');
$date_end = new DateTime('2018-03-31 23:59:59');

$interval = '+1 days';
$date_interval = DateInterval::createFromDateString($interval);

$period = new DatePeriod($date_start, $date_interval, $date_end);

foreach($period as $dt) {
echo $dt->format('d-m-Y')."<br>";
}

$carpeta = 'carpeta';
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}
*/
?>
<?php
setlocale(LC_ALL, 'es_AR.UTF8');
echo(strftime('%Y. %B %d. %A' , strtotime("08/11/2018")));
?>
