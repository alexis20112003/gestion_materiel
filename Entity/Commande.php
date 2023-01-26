<?php


class Commande
{

    private $id;

    private $id_materiels;

    private $date_debut;

    private $date_fin;

    private $restitute;

    private $date_restitute;

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

    public function getRestitute()
    {
        return $this->restitute;
    }

    public function setRestitute($restitute)
    {
        $this->restitute = $restitute;
    }

    public function getDate_restitute()
    {
        return $this->date_restitute;
    }

    public function setDate_restitute($date_restitute)
    {
        $this->date_restitute = $date_restitute;
    }

    private function getFromDatabase()
    {

        $requete = $GLOBALS['database']->prepare("SELECT * FROM `commande` WHERE `id_commande` = :id");
        $requete->bindValue(':id', $this->id);

        $requete->execute();

        $result = $requete->fetch(PDO::FETCH_ASSOC);
        if ($data = $result) {

            $this->id = $data['id_commande'];

            $this->id_materiels = $data['id_materiels'];

            $this->date_debut = $data['date_debut'];

            $this->date_fin = $data['date_fin'];

            $this->restitute = $data['restitute'];

            $this->date_restitute = $data['date_restitute'];
        }
    }

    public static function selectCommandeStatut()
    {
        $list = array();

        $requete = $GLOBALS['database']->prepare("SELECT * FROM `commande`
		INNER JOIN `commande_materiel` ON `commande_materiel`.`id_commande` = `commande`.`id_commande`
		INNER JOIN `materiels` ON `materiels`.`id_materiels` = `commande_materiel`.`id_materiels`
        INNER JOIN `utilisateur` ON `utilisateur`.`id_utilisateur` = `commande`.`id_utilisateur`
        WHERE (CURRENT_DATE < `commande_materiel`.`date_debut` OR CURRENT_DATE =`commande_materiel`.`date_debut`) 
        AND `commande`.`statut` = 0;");

        $requete->execute();

        $commands = $requete->fetchAll(PDO::FETCH_ASSOC);

        foreach ($commands as $command) {
            $list[$command['id_commande']][] = $command;
        }

        return $list;
    }

    public static function selectInfoLastCommande()
    {
        $list = array();

        $lastid = $GLOBALS['database']->lastInsertId();
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `commande`
		INNER JOIN `commande_materiel` ON `commande_materiel`.`id_commande` = `commande`.`id_commande`
		INNER JOIN `materiels` ON `materiels`.`id_materiels` = `commande_materiel`.`id_materiels`
        INNER JOIN `utilisateur` ON `utilisateur`.`id_utilisateur` = `commande`.`id_utilisateur`
        WHERE `commande`.`id_commande` = :id;");
        $requete->bindValue(':id', $lastid);

        $requete->execute();

        $commands = $requete->fetchAll(PDO::FETCH_ASSOC);

        foreach ($commands as $command) {
            $list[$command['id_commande']][] = $command;
        }

        return $list;
    }

    public static function selectCommandeGive()
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `commande_materiel`
		INNER JOIN `materiels` ON `materiels`.`id_materiels` = `commande_materiel`.`id_materiels`
		INNER JOIN `commande` ON `commande`.`id_commande` = `commande_materiel`.`id_commande`
        INNER JOIN `utilisateur` ON `utilisateur`.`id_utilisateur` = `commande`.`id_utilisateur`
        WHERE CURRENT_DATE =`commande_materiel`.`date_debut`
        AND `commande`.`statut` = 1
        AND `commande_materiel`.`restitute` = 0;");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function selectCommandeRecover()
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `commande_materiel`
		INNER JOIN `materiels` ON `materiels`.`id_materiels` = `commande_materiel`.`id_materiels`
		INNER JOIN `commande` ON `commande`.`id_commande` = `commande_materiel`.`id_commande`
        INNER JOIN `utilisateur` ON `utilisateur`.`id_utilisateur` = `commande`.`id_utilisateur`
        WHERE (CURRENT_DATE =`commande_materiel`.`date_fin` OR CURRENT_DATE >`commande_materiel`.`date_fin`)
        AND `commande`.`statut` = 1
        AND `commande_materiel`.`restitute` = 1;");

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public  static function selectAllCommande($id)
    {
        $requete = $GLOBALS['database']->prepare("SELECT * FROM `commande` WHERE `id_utilisateur` = :id");
        $requete->bindValue(':id', $id);

        $requete->execute();

        $result = $requete->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public  function deleteCommande()
    {
        $requete = $GLOBALS['database']->prepare("DELETE FROM `commande` WHERE `id_commande` = :id");
        $requete2 = $GLOBALS['database']->prepare("DELETE FROM `commande_materiel` WHERE `id_commande` = :id");
        $requete->bindValue(':id', $this->id);
        $requete2->bindValue(':id', $this->id);

        $requete->execute();
        $requete2->execute();
    }


    public  function insertCommande($idUser, $id)
    {

        $requete = $GLOBALS['database']->prepare("INSERT INTO `commande` (`id_utilisateur`, `statut`) VALUES (:id, :statut)");
        $requete->bindValue(':id', $idUser);
        $requete->bindValue(':statut', 0);
        $requete->execute();
        $lastid = $GLOBALS['database']->lastInsertId();
        foreach ($id as $value) {


            $requete2 = $GLOBALS['database']->prepare("INSERT INTO `commande_materiel` (`id_commande`, `id_materiels`, `date_debut`, `date_fin`, `restitute`) VALUES (:id, :id_mat, :date_debut, :date_fin, :restitute)");
            $requete2->bindValue(':id', $lastid);
            $requete2->bindValue(':id_mat', $value);
            $requete2->bindValue(':date_debut', $this->date_debut);
            $requete2->bindValue(':date_fin', $this->date_fin);
            $requete2->bindValue(':restitute', $this->restitute);


            $requete2->execute();
        }
    }

    public  function updateDemandeGive($id)
    {

        $requete = $GLOBALS['database']->prepare("UPDATE `commande_materiel` SET `restitute` = :restitute WHERE `id_commande` = :id");
        $requete->bindValue(':id', $id);
        $requete->bindValue(':restitute', 1);
        $requete->execute();
    }

    public  function updateDemandeRecover($id)
    {

        $requete = $GLOBALS['database']->prepare("UPDATE `commande_materiel` SET `restitute` = :restitute, `date_restitute` = CURRENT_TIMESTAMP WHERE `id_commande` = :id");
        $requete->bindValue(':id', $id);
        $requete->bindValue(':restitute', 2);
        $requete->execute();
    }

    public  function refuseDemandeMateriel($id)
    {

        $requete = $GLOBALS['database']->prepare("UPDATE `commande` SET `statut` = :statut WHERE `id_commande` = :id");
        $requete->bindValue(':id', $id);
        $requete->bindValue(':statut', 2);
        $requete->execute();
    }

    public  function acceptDemandeMateriel($id)
    {

        $requete = $GLOBALS['database']->prepare("UPDATE `commande` SET `statut` = :statut WHERE `id_commande` = :id");
        $requete->bindValue(':id', $id);
        $requete->bindValue(':statut', 1);
        $requete->execute();
    }
}
