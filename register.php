<?php
spl_autoload_register(function ($className) {
     include ("lib/{$className}.class.php");
 });

require('views/pageRegister.php');

 ?>
