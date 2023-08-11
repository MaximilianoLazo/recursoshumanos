<?php
  //$fileName = basename($id);
  //$fileName = $id;
  $filePath = 'includes/files/'.$fileName;
  if(!empty($fileName) && file_exists($filePath)){
      // Define headers
      header ("Content-Disposition: attachment; filename=".$fileName." ");
      header ("Content-Type: application/pdf");
      //header ("Content-Type: application/octet-stream");
      header ("Content-Length: ".filesize($filePath));
      // Read the file
      readfile($filePath);
      exit;
  }else{
      echo "The file does not exist."."<br>".$fileName;
  }

?>
