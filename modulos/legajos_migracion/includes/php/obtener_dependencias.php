<?php
		require_once '../../../../database/Conexion.php';
		require_once '../../model/empleado.php';
		$ic = $_GET['imputacion'];
		$dependencias = new Empleado();
		$dependenciaid = null;

		if(is_numeric($pa)){
			$imputacionid = $pa;
		}else{
			$ic = explode("-", $ic);
			$imputacionid = $ic[0];
			$dependenciaid = $ic[1];
		}
		echo "<option value=''>--Seleccione--</option>";
		foreach($dependencias->ObtenerDependencias($imputacionid) as $row){
?>
			<!--<option value="">SELECCIONE</option>-->
			<option value="<?php echo $row->impdependencia_id; ?>"<?php if (!(strcmp($row->impdependencia_id, $dependenciaid))) {echo "selected=\"selected\"";} ?>><?php echo $row->impdependencia_nombre; ?></option>
<?php
		}
?>
