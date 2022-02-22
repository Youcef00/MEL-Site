<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');



require_once('lib/watchdog.php');

if (isset($_SESSION['ident'])) {
  produceResult($_SESSION['ident']);
}
else {
  produceError("Not logged in!");
}

 ?>
