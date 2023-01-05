<?php


class Commande
{

    private $id;

    private $id_materiels;

    private $date_debut;

    private $date_fin;

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

    public function getId_materiels()
    {
        return $this->id_materiels;
    }

    public function setId_materiels($id_materiels)
    {
        $this->id_materiels = $id_materiels;
    }

    public function getDate_debut()
    {
        return $this->date_debut;
    }

    public function setDate_debut($date_debut)
    {
        $this->date_debut = $date_debut;
    }

    public function getDate_fin()
    {
        return $this->date_fin;
    }

    public function setDate_fin($date_fin)
    {
        $this->date_fin = $date_fin;
    }

    private function getFromDatabase()
    {

        $requete = $GLOBALS['database']->prepare("SELECT * FROM `commande` WHERE `id_commande` = $this->id");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);
        if ($data = $result) {

            $this->id = $data['id_commande'];

            $this->id_materiels = $data['id_materiels'];

            $this->date_debut = $data['date_debut'];

            $this->date_fin = $data['date_fin'];
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
        $requete = $GLOBALS['database']->prepare("DELETE FROM `commande` WHERE `id_commande` = :id");
        $requete2 = $GLOBALS['database']->prepare("DELETE FROM `commande_material` WHERE `id_commande` = :id");
        $requete->bindValue(':id', $this->id);
        $requete2->bindValue(':id', $this->id);

        $requete->execute();
        $requete2->execute();
    }
}
