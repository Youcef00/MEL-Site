<?php
set_include_path('..'.PATH_SEPARATOR);
require_once('lib/common_service.php');
require_once('lib/initDataLayerLogin.php');
require_once('lib/fonctions_parms.php');

try {

  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $login = $_POST['login'];
  $password = $_POST['password'];

  $user = $dataLogin->createUser($login, $password, $nom, $prenom);

  produceResult($user);

} catch (PDOException $e) {
  produceError($e->getMessage());
}


?>
