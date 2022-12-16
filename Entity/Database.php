<?php


class Database
{

    private $db;

    public function __construct(){

        try {
            $servername = "localhost";
            $username = 'ProjetMicka';
            $password = 'lWUd352blpyiP*eD';

            $this->db = new PDO ("mysql:host=$servername;dbname=projet", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {

			error_log($e->getMessage());

            exit(0);
        }
    }

    public function mysqlConnexion(){

        return $this->db;
    }
}