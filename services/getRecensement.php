<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayer.php');

try{
  $recensement = $data->getRecensement();

  produceResult($recensement);
  
}
catch (PDOException $e){
    produceError($e->getMessage());
}


?>
