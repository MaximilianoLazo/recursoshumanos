<?php
require_once '../../../../database/Conexion.php';
require_once '../../model/empleado.php';

$constancias = new Empleado();



if(isset($_POST["employee_id"])){

   $output = '';

   /*
   $connect = mysqli_connect("localhost", "root", "Ac21Az11Ic20Cl18", "testing");
   $query = "SELECT * FROM tbl_employee WHERE id = '".$_POST["employee_id"]."'";
   $result = mysqli_query($connect, $query);
   */
   $empleadonrodocto = $_POST["employee_id"];

   $output .= '

                <table class="hijosconstancia">
                  <thead>
                    <tr>
                      <th scope="col">Nro. Docto</th>
                      <th scope="col">Apellido y Nombres</th>
                      <th scope="col">Escuela</th>
                      <th scope="col" width="6%">
                        <div class="custom-control custom-checkbox mb-5">
                          <input type="checkbox" class="custom-control-input check-all" id="customCheck1">
                          <label class="custom-control-label" for="customCheck1"></label>
                        </div>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
              ';
                foreach($constancias->ObtenerHijosEscolares2($empleadonrodocto) as $row):
   $output .= '
                 <tr>
                      <td>'.$row->leghijo_nrodocto.'</td>
                      <td>'.$row->leghijo_apellido.', '.$row->leghijo_nombres.'</td>
                      <td>'.$row->escuela_nombre.'</td>
                      <td scope="row">
                        <div class="custom-control custom-checkbox mb-5">
                          <input type="checkbox" class="custom-control-input check-cont" name="checkbox[]" value='.$row->leghijo_nrodocto.' id="checkbox['.$row->leghijo_nrodocto.']">
                          <label class="custom-control-label" for="checkbox['.$row->leghijo_nrodocto.']"></label>
                        </div>
                      </td>
                 </tr>
              ';

                endforeach;
   $output .= '
          </tbody>
        </table>

   ';
   echo $output;
}
?>
