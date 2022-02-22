<?php

set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayer.php');
require_once('lib/fonctions_parms.php');

try{

  $insee= $data->getDetails(checkUnsignedInt('insee'));
  if ($insee == NULL){
    throw new ParmsException("insee incorrect");

  }
  produceResult($insee);

}
catch (ParmsException $e){
 produceError($e->getMessage());

}
?>
