<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayer.php');
require_once('lib/fonctions_parms.php');

try{

  $territoire = checkUnsignedInt('territoire', NULL , FALSE);
  $nom = checkString('recherche', NULL, FALSE);
  $surface_min = checkNumber('surface_min', NULL, FALSE)* 10000;
  $pop_min = checkUnsignedInt('pop_min', NULL, FALSE);
  $recensement = checkUnsignedInt('recensement', NULL, FALSE);



  $communes= $data->getCommunes($territoire, $nom, $surface_min, $pop_min, $recensement);

  produceResult($communes);

}
catch (PDOException $e){
    produceError($e->getMessage());
}


 ?>
