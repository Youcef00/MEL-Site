<?php
class DataLayerLogin {
	// private ?PDO $conn = NULL; // le typage des attributs est valide uniquement pour PHP>=7.4

	private  $conn = NULL; // connexion de type PDO   compat PHP<=7.3

	/**
	 * @param $DSNFileName : file containing DSN
	 */
	function __construct(){
		$dsn = "";//DSN URL of DataBase deleted in Github code for security purposes 
		$user = ""; //password URL of DataBase deleted in Github code for security purposes
		$password = ""; //password of DataBase deleted in Github code for security purposes
		$this->connexion = new PDO($dsn, $user, $password);
		// paramètres de fonctionnement de PDO :
		$this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // déclenchement d'exception en cas d'erreur
		$this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC); // fetch renvoie une table associative
		// réglage d'un schéma par défaut :
		$this->connexion->query('set search_path=authent');
	}


    function authentificationProvisoire(string $login, string $password) : ?Identite{
       $sql = <<<EOD
			 SELECT login, password, nom, prenom
			 FROM users
			 WHERE login=:login AND password=:password
EOD;
				$binds[':login'] = $login;
				$binds[':password'] = $password;
				$stmt = $this->connexion->prepare($sql);
				$stmt->execute($binds);
				$query = $stmt->fetchAll();
				return count($query) == 0 ? NULL : new Identite($query[0]['login'], $query[0]['nom'], $query[0]['prenom']);
    }

    function authentification(string $login, string $password) : ?Identite{ // version password hash
			$sql = <<<EOD
		 SELECT login, password, nom, prenom
		 FROM users
		 WHERE login=:login
EOD;
			$binds[':login'] = $login;


			$stmt = $this->connexion->prepare($sql);
			$stmt->execute($binds);
			$query = $stmt->fetchAll();

			return ( count($query) == 0 || crypt($password, $query[0]['password']) != $query[0]['password'] ) ? NULL : new Identite($query[0]['login'], $query[0]['nom'], $query[0]['prenom']);
    }
    /**
    * @return bool indiquant si l'ajout a été réalisé
    */
    function createUser(string $login, string $password, string $nom, string $prenom) 	 {
        $sql = <<<EOD
        insert into "users" (login, password, nom, prenom)
        values (:login, :password, :nom, :prenom)
EOD;
				$binds[':login'] = $login;
				$binds[':password'] = password_hash($password,CRYPT_BLOWFISH);
				$binds[':nom'] = $nom;
				$binds[':prenom'] = $prenom;


					$stmt = $this->connexion->prepare($sql);
					$stmt->execute($binds);





    }

		function getFavoris(string $login): ?array {
			$sql = <<<EOD
			SELECT favoris
FROM users
WHERE login = :login
EOD;

	$binds[':login'] = $login;
	$stmt = $this->connexion->prepare($sql);
	$stmt->execute($binds);
	$res = $stmt->fetchAll();
	return $res;
		}

		function addFavori(string $insee, string $login): string{
			$sql = <<<EOD
			UPDATE users
SET favoris = array_append(favoris, :insee)
WHERE login = :login
EOD;

			$binds[':insee'] = $insee;
			$binds[':login'] = $login;
			$stmt = $this->connexion->prepare($sql);
			$stmt->execute($binds);
			return $insee;
		}

		function removeFavori(string $insee, string $login): string{
			$sql = <<<EOD
			UPDATE users
SET favoris = array_remove(favoris, :insee)
WHERE login = :login
EOD;

			$binds[':insee'] = $insee;
			$binds[':login'] = $login;
			$stmt = $this->connexion->prepare($sql);
			$stmt->execute($binds);
			return $insee;
		}

}
?>
