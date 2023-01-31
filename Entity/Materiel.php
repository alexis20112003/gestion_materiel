<?php

class Materiel
{

    private $id;

    private $nom;

    private $description;

    private $caution;

    private $enable;

    private $id_type_materiel;


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

    public function getEnable()
    {
        return $this->enable;
    }

    public function setEnable($enable)
    {
        $this->enable = $enable;
    }

    public function getId_type_materiel()
    {
        return $this->id_type_materiel;
    }

    public function setId_type_materiel($id_type_materiel)
    {
        $this->id_type_materiel = $id_type_materiel;
    }

    private function getFromDatabase()
    {

        $requete = $GLOBALS['database']->prepare("SELECT * FROM `materiels` WHERE `id_materiels` = :id");
        $requete->bindValue(':id', $this->id);
        $requete->execute();

        $result = $requete->fetch(PDO::FETCH_ASSOC);
        if ($data = $result) {

            $this->nom = $data['nom_materiel'];

            $this->description = $data['description'];

            $this->caution = $data['caution'];

            $this->id_type_materiel = $data['id_type_materiel'];

            $this->enable = $data['enable'];
        }
    }

    public function updateMateriel()
    {
        $requete = $GLOBALS['database']->prepare("UPDATE `materiels` SET `nom_materiel`=:nom, `description`=:description, `caution`=:caution, `enable`=:enable, `id_type_materiel`=:typeMateriel WHERE `id_materiels`= :id");
        $requete->bindValue(':id', $this->id);
        $requete->bindValue(':nom', $this->nom);
        $requete->bindValue(':description', $this->description);
        $requete->bindValue(':caution', $this->caution);
        $requete->bindValue(':enable', $this->enable);
        $requete->bindValue(':typeMateriel', $this->id_type_materiel);

        $requete->execute();
    }

    public  static function selectAllMateriel()
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `materiels`");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function selectIdTypeMateriel($id)
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `materiels` WHERE `id_type_materiel` = :id");
        $requete->bindValue(':id', $id);

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function selectIdTypeMaterielDemande($id, $date_debut, $date_fin)
    {

        $list = array();
        $list_not_dispo = array();

        $requete = $GLOBALS['database']->prepare("SELECT *  FROM `materiels`
        WHERE `id_type_materiel`= $id ");
        $requete->bindValue(':id', $id);
        $requete->execute();
        $result = $requete->fetchAll(PDO::FETCH_ASSOC);



        $requete2 = $GLOBALS['database']->prepare("SELECT *, `materiels`.`id_materiels` AS idMat FROM `materiels`
        INNER JOIN `commande_materiel` ON `commande_materiel`.`id_materiels` = `materiels`.`id_materiels`
        INNER JOIN `commande` ON `commande`.`id_commande` = `commande_materiel`.`id_commande`
        WHERE `id_type_materiel`= :id
        AND (`commande_materiel`.`date_debut`  BETWEEN :date_debut AND :date_fin
        OR `commande_materiel`.`date_fin`  BETWEEN :date_debut AND :date_fin
        AND :date_debut  BETWEEN `commande_materiel`.`date_debut` AND `commande_materiel`.`date_fin`
        OR :date_fin  BETWEEN `commande_materiel`.`date_debut` AND `commande_materiel`.`date_fin`)
        AND `commande`.`statut` = 1");
        $requete2->bindValue(':id', $id);

        $requete2->bindValue(':date_debut', $date_debut);
        $requete2->bindValue(':date_fin', $date_fin);
        $requete2->execute();
        $result2 = $requete2->fetchAll(PDO::FETCH_ASSOC);


        foreach ($result2 as $key => $no_materiel) {
            array_push($list_not_dispo, $no_materiel['idMat']);
        }



        foreach ($result as $key => $materiel) {
            if (!in_array($materiel['id_materiels'], $list_not_dispo)) {
                array_push($list, $materiel);
            }
        }




        return $list;
    }

    public static function verifMaterielDemande($date_debut, $date_fin)
    {

        $requete2 = $GLOBALS['database']->prepare("SELECT *, `materiels`.`id_materiels` AS idMat FROM `materiels`
        INNER JOIN `commande_materiel` ON `commande_materiel`.`id_materiels` = `materiels`.`id_materiels`
        INNER JOIN `commande` ON `commande`.`id_commande` = `commande_materiel`.`id_commande`
        WHERE (`commande_materiel`.`date_debut`  BETWEEN :date_debut AND :date_fin
        OR `commande_materiel`.`date_fin`  BETWEEN :date_debut AND :date_fin
        AND :date_debut  BETWEEN `commande_materiel`.`date_debut` AND `commande_materiel`.`date_fin`
        OR :date_fin  BETWEEN `commande_materiel`.`date_debut` AND `commande_materiel`.`date_fin`)
        AND `commande`.`statut` = 1");

        $requete2->bindValue(':date_debut', $date_debut);
        $requete2->bindValue(':date_fin', $date_fin);
        $requete2->execute();
        $result2 = $requete2->fetchAll(PDO::FETCH_ASSOC);

        return $result2;
    }

    public static function sqlCount($id)
    {
        $requete = $GLOBALS['database']->prepare("SELECT COUNT(*) as nb FROM `materiels` WHERE `id_type_materiel` = :id");
        $requete->bindValue(':id', $id);

        $requete->execute();

        $result = $requete->fetch(PDO::FETCH_ASSOC);

        return $result["nb"];
    }

    public static function typeMateriel()
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `type_materiel`");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public  function deleteMateriel()
    {
        $requete = $GLOBALS['database']->prepare("DELETE FROM `materiels` WHERE `id_materiels`= :id");
        $requete->bindValue(':id', $this->id);
        $requete->execute();
    }

    public  function insertMateriel()
    {
        if ($this->id == 0) {
            $requete = $GLOBALS['database']->prepare("INSERT INTO `materiels` (`nom_materiel`, `description`, `caution`, `id_type_materiel`) VALUES (:nom, :description, :caution, :id)");
            $requete->bindValue(':nom', $this->nom);
            $requete->bindValue(':description', $this->description);
            $requete->bindValue(':caution', $this->caution);
            $requete->bindValue(':id', $this->id_type_materiel);


            $requete->execute();
        }
    }
    public static function selectCommandeIdMateriel($id)
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `commande`
        INNER JOIN `commande_materiel` ON `commande_materiel`.`id_commande` = `commande`.`id_commande` 
        INNER JOIN `utilisateur` ON `commande`.`id_utilisateur` = `utilisateur`.`id_utilisateur`
        INNER JOIN `materiels` ON `materiels`.`id_materiels` = `commande_materiel`.`id_materiels`
        WHERE `commande_materiel`.`id_materiels` = :id 
        AND (`commande`.`statut` = 1 OR `commande`.`statut` = 2)");
        $requete->bindValue(':id', $id);

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    public static function detailMaterielById($id)
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `materiels` 
        INNER JOIN `type_materiel` ON `type_materiel`.`id_type_materiel` = `materiels`.`id_type_materiel`
        WHERE `id_materiels` = :id");
        $requete->bindValue(':id', $id);

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
