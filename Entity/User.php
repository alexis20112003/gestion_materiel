<?php


class User
{

	private $id;

	private $nom;

	private $prenom;

	private $email;

	private $pass;

	private $promo;

	private $statut;

	private $enable;


	public function __construct($id)
	{

		$this->id = $id;

		if ($id != 0) {
			$this->getFromDatabase();
		}
	}

	/**
	 * Get the user primary key
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Set the user primary key
	 *
	 * @param int $id 
	 *
	 * @return void	
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * Get the user nom
	 *
	 * @return string
	 */
	public function getNom()
	{
		return $this->nom;
	}

	/**
	 * Set the user nom
	 *
	 * @param string $nom 
	 *
	 * @return void	
	 */
	public function setNom($nom)
	{
		$this->nom = $nom;
	}

	/**
	 * Get the user prenom
	 *
	 * @return string
	 */
	public function getPrenom()
	{
		return $this->prenom;
	}

	/**
	 * Set the user prenom
	 *
	 * @param string $prenom 
	 *
	 * @return void	
	 */
	public function setPrenom($prenom)
	{
		$this->prenom = $prenom;
	}

	/**
	 * Get the user email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}


	/**
	 * Set the user email
	 *
	 * @param string $email 
	 *
	 * @return void	
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * Get the user pass
	 *
	 * @return string
	 */
	public function getPass()
	{
		return $this->pass;
	}

	/**
	 * Set the user pass
	 *
	 * @param string $pass 
	 *
	 * @return void	
	 */
	public function setPass($pass)
	{
		$options = [
			'cost' => 8,
		];

		return $this->pass = password_hash($pass, PASSWORD_BCRYPT, $options);
	}

	public function getPromo()
	{
		return $this->promo;
	}

	public function setPromo($promo)
	{
		$this->promo = $promo;
	}

	public function getStatut()
	{
		return $this->statut;
	}

	public function setStatut($statut)
	{
		$this->statut = $statut;
	}

	public function getEnable()
	{
		return $this->enable;
	}

	public function setEnable($enable)
	{
		$this->enable = $enable;
	}

	public static function randomPassword()
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //le pass est une liste
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //renvoi le pass en string

	}

	private function getFromDatabase()
	{

		$requete = $GLOBALS['database']->prepare('SELECT * FROM `utilisateur` 
        INNER JOIN `utilisateur_type` ON `utilisateur`.`id_utilisateur` = `utilisateur_type`.`id_utilisateur`
        INNER JOIN `type` ON `utilisateur_type`.`id_type` = `type`.`id_type`
        WHERE `utilisateur`.`id_utilisateur` = :id');
		$requete->bindvalue(":id", $this->id);
		$requete->execute();
		$user = $requete->fetch(PDO::FETCH_ASSOC);

		$this->nom = $user['nom'];

		$this->prenom = $user['prenom'];

		$this->email = $user['email'];

		$this->pass = $user['password'];

		$this->promo = $user['promo'];

		$this->statut = $user['statut'];

		$this->enable = $user['enable'];
	}


	public static function isExist($user)
	{

		$is_exist = false;

		$requete = $GLOBALS['database']->prepare("SELECT * 
		FROM `utilisateur`
		WHERE `nom` = :pseudo
		AND `email` = :email ");

		$requete->bindValue(':pseudo', $user['pseudo']);
		$requete->bindValue(':email', $user['email']);

		$requete->execute();

		$result = $requete->fetchAll(PDO::FETCH_ASSOC);

		if ($user = $result) {

			$is_exist = true;
		}

		return $is_exist;
	}

	public static function getUserByLogin($email)
	{

		$response = array();

		$requete = $GLOBALS['database']->prepare("SELECT * 
		FROM `utilisateur` 
		WHERE `email` = :email ");
		$requete->bindValue(':email', $email);

		$requete->execute();

		$result = $requete->fetchAll(PDO::FETCH_ASSOC);

		if ($data = $result) {

			$response = $data;
		}

		return $response;
	}

	public  static function selectAllUser()
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `utilisateur`");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

	
	public static function selectUserbyType($id)
	{
		$requete = $GLOBALS['database']->prepare("SELECT * FROM `utilisateur`
		INNER JOIN `utilisateur_type` ON `utilisateur`.`id_utilisateur` = `utilisateur_type`.`id_utilisateur`
        INNER JOIN `type` ON `utilisateur_type`.`id_type` = `type`.`id_type`
		WHERE `type`.`id_type` = :id");

		$requete->bindValue(':id', $id);

		$requete->execute();

		$result = $requete->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}
	public static function selectTypebyUser($id)
	{
		$requete = $GLOBALS['database']->prepare("SELECT * FROM `type`
		INNER JOIN `utilisateur_type` ON `type`.`id_type` = `utilisateur_type`.`id_type`
        INNER JOIN `utilisateur` ON `utilisateur_type`.`id_utilisateur` = `utilisateur`.`id_utilisateur`
		WHERE `utilisateur`.`id_utilisateur` = :id");

		$requete->bindValue(':id', $id);

		$requete->execute();

		$result = $requete->fetch(PDO::FETCH_ASSOC);

		return $result;
	}
	public static function typeUser()
	{
		$requete = $GLOBALS['database']->prepare("SELECT * FROM `type`");

		$requete->execute();

		$result = $requete->fetchAll(PDO::FETCH_ASSOC);

		return array_reverse($result);
	}

	public static function selectSites()
	{
		$requete = $GLOBALS['database']->prepare("SELECT * FROM `site`");

		$requete->execute();

		$result = $requete->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}
	public static function selectUserSite($id)
	{
		$requete = $GLOBALS['database']->prepare("SELECT * FROM `site`
		INNER JOIN `utilisateur_site` ON `site`.`id_site` = `utilisateur_site`.`id_site`
		INNER JOIN `utilisateur` ON `utilisateur_site`.`id_utilisateur` = `utilisateur`.`id_utilisateur`
		WHERE `utilisateur`.`id_utilisateur` = :id");

		$requete->bindValue(':id', $id);

		$requete->execute();

		$result = $requete->fetch(PDO::FETCH_ASSOC);

		return $result;
	}


	public static function userCount($id)
	{
		$requete = $GLOBALS['database']->prepare("SELECT COUNT(*) as nb FROM `utilisateur` 
		INNER JOIN `utilisateur_type` ON `utilisateur`.`id_utilisateur` = `utilisateur_type`.`id_utilisateur`
        INNER JOIN `type` ON `utilisateur_type`.`id_type` = `type`.`id_type`
        WHERE `type`.`id_type` = :id");
		$requete->bindValue(':id', $id);

		$requete->execute();

		$result = $requete->fetch(PDO::FETCH_ASSOC);

		return $result["nb"];
	}


	public function register($site, $status)
	{

		if ($this->id == 0) {
			$requete = $GLOBALS['database']->prepare("INSERT INTO `utilisateur` (`nom`, `prenom`, `email`, `password`, `promo`) VALUES (:nom, :prenom, :email, :pass, :promo)");
			$requete->bindValue(':nom', $this->nom);
			$requete->bindValue(':prenom', $this->prenom);
			$requete->bindValue(':email', $this->email);
			$requete->bindValue(':pass', $this->pass);

			$requete->bindValue(':promo', $this->promo);

			if ($requete->execute()) {

				$this->id = $GLOBALS['database']->lastInsertId();
				$requeteType = $GLOBALS['database']->prepare("INSERT INTO `utilisateur_type` (`id_utilisateur`, `id_type`) VALUES (:id, :status)");
				$requeteType->bindValue(':id', $this->id);
				$requeteType->bindValue(':status', $status);

				$requeteType->execute();

				$requeteSite = $GLOBALS['database']->prepare("INSERT INTO `utilisateur_site` (`id_utilisateur`, `id_site`) VALUES (:id, :site)");
				$requeteSite->bindValue(':id', $this->id);
				$requeteSite->bindValue(':site', $site);

				$requeteSite->execute();
			}
		}
	}

	public function updateUser()
	{
		$requete = $GLOBALS['database']->prepare("UPDATE `utilisateur` SET `nom`=:nom, `prenom`=:prenom, `email`= :email, `enable`=:enable WHERE `id_utilisateur`= :userId");
		$requete->bindValue(':nom', $this->nom);
		$requete->bindValue(':prenom', $this->prenom);
		$requete->bindValue(':email', $this->email);
		$requete->bindValue(':enable', $this->enable);
		$requete->bindValue(':userId', $this->id);
	
		$requete->execute();
	}
}
