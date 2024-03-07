<?php
class DbConfig
{
    private PDO $linkpdo;

    private function __construct()
    {
        try {
            $this->linkpdo = new PDO('mysql:host=localhost;dbname=projet', 'Enzo', '$iutinfo', [
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
