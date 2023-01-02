<?php

class Materiel
{

    private $id;


    private $nom;


    private $description;


    private $id_type_mat;

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

    public function getId_type_mat()
    {
        return $this->id_type_mat;
    }

    public function setId_type_mat($id_type_mat)
    {
        $this->id_type_mat = $id_type_mat;
    }

    private function getFromDatabase()
    {

        $requete = $GLOBALS['database']->prepare("SELECT * FROM `materiels` WHERE `id_materiels` = $this->id");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);
        if ($data = $result) {

            $this->nom = $data['nom'];

            $this->prenom = $data['description'];

            $this->mail = $data['id_type_mat'];
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

    public static function TypeMat()
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `type_materiel`");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public  function deleteMat()
    {
        $requete = $GLOBALS['database']->prepare("DELETE * FROM `materiels` WHERE `id_materiels`= :id");
        $requete->bindValue(':id', $this->id);

        $requete->execute();
    }
}
