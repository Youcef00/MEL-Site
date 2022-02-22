<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayerLogin.php');
require_once('lib/fonctions_parms.php');
require_once('lib/watchdog.php');

try {
  $insee = checkString('insee');
  $login = $_SESSION['ident']->login;
  if ($login === NULL) {
    throw new ParmsException("No current session");
  }
  $result = $dataLogin->removeFavori($insee, $login);
  produceResult($result);
} catch (\ParmsException $e) {
  produceError($e->getMessage());
}

 ?>
