<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");
class DbConfig
{
    private PDO $linkpdo;

    private function __construct()
    {
        try {
            // gestionmedical_bd 351413_enzo
            $this->linkpdo = new PDO('mysql:host=mysql-gestionmedical.alwaysdata.net;dbname=gestionmedical_bd', '351413', '$iutinfo', [
            // $this->linkpdo = new PDO('mysql:host=localhost;dbname=projet', 'Enzo', '$iutinfo', [

                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            echo 'Erreur de connexion : ' . $e->getMessage();
        }
    }

    public function getPDO()
    {
        return $this->linkpdo;
    }

    public static function getDbConfig()
    {
        return new DbConfig();
    }
}
?>
