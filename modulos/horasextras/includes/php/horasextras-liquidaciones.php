<?php

    include("../../database/Waldbott.php");
    require_once '../../database/Conexion.php';
    require_once 'model/horasextras.php';

    $horasextras = new HorasExtras();

    if (!$cid){
    	exit("<strong>Ya ocurrido un error tratando de conectarse con el origen de datos.</strong>");
    }
    //----Obtner todos los empleados que pierden el presentismo ---
    foreach($horasextras->ListarHorasExtras() as $row){
      $nrodocumento = $row->legempleado_nrodocto;
      //----- Obtener Empleado de Waldboot ----
      $sql = "SELECT * FROM EMPLEADO WHERE NRODOCTO = $nrodocumento AND CONDICION = '1'";
      $resultado = odbc_exec($cid, $sql)or die(exit("Error en odbc_exec_tres"));
      $datos = odbc_fetch_object($resultado);

      $nrolegajo = $datos->EMPLEADO;
      $horasjornales = $row->horas_jornales;
      $horasexsimples = $row->horasex_simples;
      $horasexdobles = $row->horasex_dobles;

      $sqltres = "UPDATE HORAS SET HORAS1 = $horasjornales, HORAS40 = $horasexsimples, HORAS41 = $horasexdobles WHERE EMPLEADO = '$nrolegajo'";
      odbc_exec($cid, $sqltres)or die(exit("Error en odbc_exec_cuatro"));

      //echo $datos->NRODOCTO."<br>".$nrodocumento."<br>".$datos->NOMBRE."<BR>----------------<BR>";
    }



?>
