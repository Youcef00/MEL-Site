<?php

set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayerLogin.php');
require_once('lib/fonctions_parms.php');

//echo "{login: {$login}, password: {$password}}";
/***

$login = checkString('login', NULL, FALSE);
$password = checkString('password', NULL, FALSE);
 * test si le script s'exécute dans une session où l'utilisateur s'est déjà authentifié
 * se fonde sur le témoin d'authentification : $_SESSION['ident']
 */

 require_once('lib/watchdog.php');

 if ( !alreadyLogged()){ // pas déja loggé et pas de connexion correcte
    $connect = tryConnect($my_authent);
    if (!$connect) {
      produceError("Cant connect! login and pass incorrect or missing!");
      //exit; // Important !
    }
    else {
      produceResult($_SESSION['ident']);
      //exit;

    }
 }
 else {
   produceError("Already Logged!");
 }
