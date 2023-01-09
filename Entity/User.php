<?php


class User
{

	private $id;

	private $nom;

	private $prenom;

	private $mail;

	private $pass;

	private $promo;

	private $statut;

	private $enable;


	public function __construct($id)
	{

		$this->id = $id;

		$this->getFromDatabase();
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
	 * Get the user mail
	 *
	 * @return string
	 */
	public function getMail()
	{
		return $this->mail;
	}


	/**
	 * Set the user mail
	 *
	 * @param string $mail 
	 *
	 * @return void	
	 */
	public function setMail($mail)
	{
		$this->mail = $mail;
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

		$this->pass = password_hash($pass, PASSWORD_BCRYPT, $options);
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

	private function getFromDatabase()
	{

		$requete = $GLOBALS['database']->prepare('SELECT * FROM `utilisateur` 
        INNER JOIN `utilisateur_type` ON `utilisateur`.`id_utilisateur` = `utilisateur_type`.`id_utilisateur`
        INNER JOIN type ON `utilisateur_type`.`id_type` = `type`.`id_type`
        WHERE `utilisateur`.`id_utilisateur` = :id');
		$requete->bindvalue(":id", $this->id);
		$requete->execute();
		$user = $requete->fetch(PDO::FETCH_ASSOC);

		$this->nom = $user['nom'];

		$this->prenom = $user['prenom'];

		$this->mail = $user['email'];

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


	public function register($site, $status)
	{
		if ($this->id == 0) {
			$requete = $GLOBALS['database']->prepare("INSERT INTO `utilisateur` (`nom`, `prenom`, `email`, `password`) VALUES (:nom, :prenom, :mail, :pass)");
			$requete->bindValue(':nom', $this->nom);
			$requete->bindValue(':prenom', $this->prenom);
			$requete->bindValue(':mail', $this->mail);
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

	public function updateAll()
	{
		$requete = $GLOBALS['database']->prepare("UPDATE `utilisateur` SET `nom`=:nom, `prenom`=:prenom, `email`= :mail, WHERE `id_utilisateur`= :id");
		$requete->bindValue(':nom', $this->nom);
		$requete->bindValue(':prenom', $this->prenom);
		$requete->bindValue(':mail', $this->mail);
		$requete->bindValue(':id', $this->id);

		$requete->execute();
	}
}
