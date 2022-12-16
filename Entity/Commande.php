<?php


class User
{

    private $id;

    private $id_utilisateur;

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

    public function getId_utilisateur()
    {
        return $this->id_utilisateur;
    }

    public function setId_utilisateur($id_utilisateur)
    {
        $this->id_utilisateur = $id_utilisateur;
    }
    private function getFromDatabase()
    {

        $requete = $GLOBALS['database']->prepare("SELECT * FROM `commande` WHERE `id_commande` = $this->id");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);
        if ($data = $result) {

            $this->id = $data['id'];

            $this->id_utilisateur = $data['id_utilisateur'];
        }
    }

    public static function selectIdUser($id)
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `commande` WHERE `id_utilisateur` = :id");
        $requete->bindValue(':id', $id);

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public  static function selectAllCom()
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `commande`");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public  function deleteCom()
    {
        $requete = $GLOBALS['database']->prepare("DELETE * FROM `commande` WHERE `id_commande` = :id");
        $requete->bindValue(':id', $this->id);

        $requete->execute();
    }
}
