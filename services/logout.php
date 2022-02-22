<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayerLogin.php');
require_once('lib/fonctions_parms.php');

require_once('lib/watchdog.php'); // sentinelle

  if (! isset($_SESSION['ident'])) {
    produceError('Not logged in');

  }
  else {
    $ident = $_SESSION['ident'];
    session_destroy();
    produceResult($ident);
  }

 ?>
