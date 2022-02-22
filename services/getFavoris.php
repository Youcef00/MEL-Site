<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayerLogin.php');
require_once('lib/fonctions_parms.php');
require_once('lib/watchdog.php');

try {

  $login = $_SESSION['ident']->login;
  if ($login === NULL) {
    produceError("No current session");
    exit;
  }
  $favoris = $dataLogin->getFavoris($login);
  produceResult($favoris);
} catch (\ParmsException $e) {
  produceError($e->getMessage());
}



 ?>
