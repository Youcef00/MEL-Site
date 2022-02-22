<?php
class Identite { 
  public $login;
  public $nom;
  public $prenom;
  public function __construct(string $login, string $nom, string $prenom)
  {
    $this->login = $login;
    $this->nom = $nom;
    $this->prenom = $prenom;
  }
}
?>