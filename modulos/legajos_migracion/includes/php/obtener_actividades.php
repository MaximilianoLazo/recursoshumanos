<?php
		require_once '../../../../database/Conexion.php';
		require_once '../../model/empleado.php';
		$ia = $_GET['imputacion'];
		$actividades = new Empleado();
		$actividadid= null;

		if(is_numeric($pa)){
			$imputacionid = $pa;
		}else{
			$ia = explode("-", $ia);
			$imputacionid = $ia[0];
			$actividadid = $ia[1];
		}
		echo "<option value=''>-- SELECCIONE --</option>";
		foreach($actividades->ObtenerActividades($imputacionid) as $row){
?>
			<!--<option value="">SELECCIONE</option>-->
			<option value="<?php echo $row->impactividad_id; ?>"<?php if (!(strcmp($row->impactividad_id, $actividadid))) {echo "selected=\"selected\"";} ?>><?php echo $row->impactividad_nombre; ?></option>
<?php
		}
?>
