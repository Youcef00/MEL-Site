<?php
class DataLayer {
	// private ?PDO $conn = NULL; // le typage des attributs est valide uniquement pour PHP>=7.4

	private  $connexion = NULL; // connexion de type PDO   compat PHP<=7.3

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
		$this->connexion->query('set search_path=communes_mel, authent');
	}

	/**
	 * Liste des territoires
	 * @return array tableau de territoires
	 * chaque territoire comporte les clés :
		* id (identifiant, entier positif),
		* nom (chaîne),
		* min_lat (latitude minimale, flottant),
		* min_lon (longitude minimale, flottant),
		* max_lat, max_lon
	 */
	function getTerritoires(): array {
		$sql = "select id, nom , min_lat, min_lon, max_lat, max_lon from territoires join bb_territoires on id=territoire";
		$stmt = $this->connexion->prepare($sql);
		$stmt->execute();
		$res= $stmt->fetchAll();
		return $res;
	}

	/**
	 * Liste de communes correspondant à certains critères
	 * @param territoire : territoire des communes cherchées
	 * @return array tableau de communes (info simples)
	 * chaque commune comporte les clés :
		* insee (chaîne),
		* nom (chaîne),
		* lat, lon
		* min_lat (latitude minimale, flottant),
		* min_lon (longitude minimale, flottant),
		* max_lat, max_lon
	 */
	function getCommunes(?int $territoire=NULL, ?string $nom=NULL, ?float $surface_min=NULL, ?int $pop_min=NULL, ?int $recensement=NULL): array {
		$sql = <<<EOD
			SELECT communes.insee, nom, lat, lon, min_lat, min_lon, max_lat, max_lon
			FROM communes_mel.communes
			NATURAL JOIN bb_communes LEFT JOIN population ON communes.insee = population.insee
EOD;
		$conds =[];  // tableau contenant les code SQL de chaque condition à appliquer
		$binds=[];   // association entre le nom de pseudo-variable et sa valeur

		if ($territoire !== NULL){
			$conds[] = "territoire = :territoire";
			$binds[':territoire'] = $territoire;
		}
		if ($nom !== NULL) {
			$conds[] = "nom ILIKE :nom";
			$binds[':nom'] = '%'.$nom.'%';
		}
		if ($surface_min !== NULL) {
			$conds[] = "surface >= :surface_min";
			$binds[':surface_min'] = $surface_min;
		}
		if ($pop_min !== NULL && $recensement !== NULL) {
			$conds[] = "pop_mun >= :pop_min and recensement = :recensement";
			$binds[':pop_min'] = $pop_min;
			$binds[':recensement'] = $recensement;
		}
		if ($pop_min !== NULL && $recensement === NULL) {
			$conds[] = "pop_mun >= :pop_min";
			$binds[':pop_min'] = $pop_min;
		}
		if ($pop_min === NULL && $recensement !== NULL) {
			$conds[] = "recensement = :recensement";
			$binds[':recensement'] = $recensement;
		}
		if ($recensement === NULL) {
			$conds[] = "(recensement = 2016 or recensement is null)";

		}



		if (count($conds)>0){ // il ya au moins une condition à appliquer ---> ajout d'ue clause where
			$sql .= " where ". implode(' and ', $conds); // les conditions sont reliées par AND
		}
		$stmt = $this->connexion->prepare($sql);
		$stmt->execute($binds);
		$res= $stmt->fetchAll() ;
		return $res;
	}


	/**
	 * Information détaillée sur une commune
	 * @param insee : code insee de la commune
	 * @return commune ou NULL si commune inexistante
	 * l'objet commune comporte les clés :
	 *	insee, nom, nom_terr, surface, perimetre, pop2016, lat, lon, geo_shape
	 */
	function getDetails(string $insee): ?array {
		$sql = <<<EOD
			select insee, communes.nom, territoires.nom as nom_terr, surface, perimetre, population.pop_totale as pop2016,
			lat, lon, geo_shape   from communes
			join communes_mel.territoires on id=territoire
			natural left join communes_mel.population
			where (recensement= 2016 or recensement is null) and insee=:insee
EOD;
		$stmt = $this->connexion->prepare($sql);
		$stmt->execute([':insee'=>$insee]);
		$res= $stmt->fetch() ;
		return $res ? $res : NULL;
	}

function getRecensement(): array{
	$sql = "select DISTINCT(recensement) from population ORDER BY recensement";
	$stmt = $this->connexion->prepare($sql);
	$stmt->execute();
	$res= $stmt->fetchAll();
	return $res;
}

}
?>
