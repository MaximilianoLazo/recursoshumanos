 <?php
 		/*require_once '../../../../database/Conexion.php';
 		require_once '../../model/empleado.php';*/

    $isa = new Indumentaria();

    $isa->Indumentariaidf = $_POST['indumentariaidf'];
    $isa->Indumentariatalleidf = $_POST['indumentariatalleidf'];
    $isa->Indumentariacoloridf = $_POST['indumentariacoloridf'];
    $datosindstock = $this->model->IndumentariaStockObtener($isa);

    $data = array();



    if($datosindstock->indumentaria_stock_id > 0){
      //----existe el registro-----
      $data["opcion"] = 1;
      $data["indumentariastockid"] = $datosindstock->indumentaria_stock_id;
      $data["indumentariaid"] = $datosindstock->indumentaria_id;
      $data["indumentariatalleid"] = $datosindstock->indumentaria_talle_id;
      $data["indumentariacolorid"] = $datosindstock->indumentaria_color_id;
      $data["indumentariacbarra"] = $datosindstock->indumentaria_stock_codigo_barra;
      $data["indumentariastockcantidad"] = $datosindstock->indumentaria_stock_cantidad;
      $data["indumentariastockminimo"] = $datosindstock->indumentaria_stock_minimo;
    }else{
      //---No existe registro
      $data["opcion"] = 0;
      $data["indumentariastockid"] = 0;
      $data["indumentariacbarra"] = "";
      $data["indumentariastockcantidad"] = "";
      $data["indumentariastockminimo"] = "";
    }


 		echo json_encode($data);
 ?>
