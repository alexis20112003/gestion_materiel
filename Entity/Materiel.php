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

    public function getEnable()
    {
        return $this->enable;
    }

    public function setEnable($enable)
    {
        $this->enable = $enable;
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

        $result = $requete->fetch(PDO::FETCH_ASSOC);
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
        $requete = $GLOBALS['database']->prepare("UPDATE `materiels` SET `nom_materiel`=:nom, `description`=:description, `caution`=:caution, `enable`=:enable, `id_type_materiel`=:TypeMat WHERE `id_materiels`= :id");
        $requete->bindValue(':id', $this->id);
        $requete->bindValue(':nom', $this->nom);
        $requete->bindValue(':description', $this->description);
        $requete->bindValue(':caution', $this->caution);
        $requete->bindValue(':enable', $this->enable);
        $requete->bindValue(':TypeMat', $this->id_type_mat);

        $requete->execute();
    }

    public  static function selectAllMat()
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `materiels`");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public  static function selecIdMat()
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `materiels` WHERE `id_materiels`= :id ");
        $requete->bindValue(':id', $id);
        $requete->execute();

        $result = $requete->fetch(PDO::FETCH_ASSOC);

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

        $list = array();
        $list_not_dispo = array();

        $requete = $GLOBALS['database']->prepare("SELECT *  FROM `materiels`
        WHERE `id_type_materiel`= $id ");
        $requete->bindValue(':id', $id);
        $requete->execute();
        $result = $requete->fetchAll(PDO::FETCH_ASSOC);



        $requete2 = $GLOBALS['database']->prepare("SELECT *, `materiels`.`id_materiels` AS idMat FROM `materiels`
        INNER JOIN `commande_material` ON `commande_material`.`id_materiels` = `materiels`.`id_materiels`
        INNER JOIN `commande` ON `commande`.`id_commande` = `commande_material`.`id_commande`
        WHERE `id_type_materiel`= :id
        AND `commande_material`.`date_fin`  BETWEEN :date_debut AND :date_fin
        AND `commande_material`.`date_debut`  BETWEEN :date_debut AND :date_fin
        AND `commande`.`statut` = 1");
        $requete2->bindValue(':id', $id);

        $requete2->bindValue(':date_debut', $date_debut);
        $requete2->bindValue(':date_fin', $date_fin);
        $requete2->execute();
        $result2 = $requete2->fetchAll(PDO::FETCH_ASSOC);


        foreach ($result2 as $key => $no_materiel) {
            array_push($list_not_dispo, $no_materiel['idMat']);
        }



        foreach ($result as $key => $mat) {
            if (!in_array($mat['id_materiels'], $list_not_dispo)) {
                array_push($list, $mat);
            }
        }


        error_log(json_encode($list));


        return $list;
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
}
