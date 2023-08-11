<?php
		require_once '../../../../database/Conexion.php';
		require_once '../../model/marcacion.php';
		$slt = $_GET['secretaria'];
		$lugaresdetrabajo = new Marcacion();
		$lugardetrabajoid = null;

		if(is_numeric($slt)){
			$secretariaid = $slt;
		}else{
			$slt = explode("-", $slt);
			$secretariaid = $slt[0];
			$lugardetrabajoid = $slt[1];
		}
		echo "<option value='T'>-- SELECCIONE --</option>";
		foreach($lugaresdetrabajo->ObtenerLugaresDeTrabajo($secretariaid) as $row){
?>
			<!--<option value="">SELECCIONE</option>-->
			<option value="<?php echo $row->trabajo_id; ?>"<?php if (!(strcmp($row->trabajo_id, $lugardetrabajoid))) {echo "selected=\"selected\"";} ?>><?php echo $row->trabajo_nombre; ?></option>
<?php
		}
?>
