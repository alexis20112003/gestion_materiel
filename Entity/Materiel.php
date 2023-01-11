<?php

class Materiel
{

    private $id;


    private $nom;


    private $description;

    private $caution;

    private $id_type_mat;

    private $enable;

    public function __construct($id)
    {
        $this->id = $id;

        $this->getFromDatabase();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getCaution()
    {
        return $this->caution;
    }

    public function setCaution($caution)
    {
        $this->caution = $caution;
    }

    public function getId_type_mat()
    {
        return $this->id_type_mat;
    }

    public function setId_type_mat($id_type_mat)
    {
        $this->id_type_mat = $id_type_mat;
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

        $requete = $GLOBALS['database']->prepare("SELECT * FROM `materiels` WHERE `id_materiels` = :id");
        $requete->bindValue(':id', $this->id);
        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);
        if ($data = $result) {

            $this->nom = $data['nom_materiel'];

            $this->description = $data['description'];

            $this->caution = $data['caution'];

            $this->id_type_mat = $data['id_type_materiel'];

            $this->enable = $data['enable'];
        }
    }

    public function updateMat()
    {
        $requete = $GLOBALS['database']->prepare("UPDATE `materiels` SET `nom_materiel`=:nom, `description`=:description, WHERE `id_materiels`= :id");
        $requete->bindValue(':id', $this->id);
        $requete->bindValue(':nom', $this->nom);
        $requete->bindValue(':description', $this->description);

        $requete->execute();
    }

    public  static function selectAllMat()
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `materiels`");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function selectIdTypeMat($id)
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `materiels` WHERE `id_type_materiel` = :id");
        $requete->bindValue(':id', $id);

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function selectIdTypeMatDemande($id, $date_debut, $date_fin)
    {
        $requete = $GLOBALS['database']->prepare("SELECT *,`materiels`.`id_materiels` AS idMat  FROM `materiels`
        LEFT JOIN `commande_material` ON `commande_material`.`id_materiels` = `materiels`.`id_materiels`
        LEFT JOIN `commande` ON `commande`.`id_commande` = `commande_material`.`id_commande`
        WHERE `id_type_materiel`= $id AND(
         (`commande_material`.`date_fin` NOT BETWEEN :date_debut AND :date_fin
        AND `commande_material`.`date_debut` NOT BETWEEN :date_debut AND :date_fin)
        OR (`commande`.`statut`=0 )
        OR `commande_material`.`id_materiels` IS NULL);");
        $requete->bindValue(':id', $id);
        $requete->bindValue(':date_debut', $date_debut);
        $requete->bindValue(':date_fin', $date_fin);

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function sqlCount($id)
    {
        $requete = $GLOBALS['database']->prepare("SELECT COUNT(*) as nb FROM `materiels` WHERE `id_type_materiel` = :id");
        $requete->bindValue(':id', $id);

        $requete->execute();

        $result = $requete->fetch(PDO::FETCH_ASSOC);

        return $result["nb"];
    }

    public static function TypeMat()
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `type_materiel`");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public  function deleteMat()
    {
        $requete = $GLOBALS['database']->prepare("DELETE FROM `materiels` WHERE `id_materiels`= :id");
        $requete->bindValue(':id', $this->id);
        $requete->execute();
    }

    public  function insertMat()
    {
        if ($this->id == 0) {
            $requete = $GLOBALS['database']->prepare("INSERT INTO `materiels` (`nom_materiel`, `description`, `caution`, `id_type_materiel`) VALUES (:nom, :description, :caution, :id)");
            $requete->bindValue(':nom', $this->nom);
            $requete->bindValue(':description', $this->description);
            $requete->bindValue(':caution', $this->caution);
            $requete->bindValue(':id', $this->id_type_mat);


            $requete->execute();
        }
    }

    // SELECT `date_debut`, `date_fin` FROM `commande_material` WHERE `id_materiels` = 5;
    // SELECT TIMEDIFF(`date_fin`, CURRENT_DATE) FROM `commande_material`,`utilisateur` WHERE `id_materiels`=5 AND `id_utilisateur`=1;
    // SELECT * FROM `materiels`, `commande_material` WHERE `id_type_materiel`=2 AND `date_fin`< CURRENT_DATE();  materiel multiplier par le nombre de commande 
    // SELECT * FROM `materiels`, `commande_material` WHERE `id_type_materiel`=2 AND `date_fin`< CURRENT_DATE() AND `restitute`=0; meme probleme mais sans mat restituer
    // SELECT * FROM `materiels`, `commande_material` WHERE `id_type_materiel`=2 AND `date_fin`< CURRENT_DATE() AND `date_debut`<CURRENT_DATE() AND `restitute`=0;
}

// SELECT * FROM `materiels`
// INNER JOIN `commande_material` ON `commande_material`.`id_materiels` = `materiels`.`id_materiels`
// INNER JOIN `commande` ON `commande`.`id_commande` = `commande_material`.`id_commande`
// WHERE `id_type_materiel`=1 
// AND (`date_fin`NOT BETWEEN "2023-01-05" AND "2023-01-07"
// AND `date_debut` NOT BETWEEN "2023-01-05" AND "2023-01-07")
// OR (`statut`=0 );
