<?php
require_once 'DbConfig.php';
class Medecin{
    private DbConfig $dbConfig;
    private $nom;
    private $prenom;
    private $civilite;
    private $Id_Medecin;

    public function __construct(){
        $this->dbConfig = DbConfig::getDbConfig();
    
    }

    function AddMedecin(){
        try{
            $req = $this->dbConfig->getPDO()->prepare('INSERT INTO medecin (civilite ,nom, prenom) 
            VALUES (:civilite,:nom, :prenom)');

            $req->execute(array(
                'civilite' => $this->civilite,
                'prenom' => $this->prenom,
                'nom' => $this->nom,

            ));
        }catch(Exception $pe){echo 'ERREUR : ' . $pe->getMessage();}

    }

    function DeleteMedecin(){
        try{
            $req = $this->dbConfig->getPDO()->prepare('DELETE FROM medecin WHERE Id_Medecin = :Id_Medecin');
            $req->execute(array(
                'Id_Medecin' => $this->Id_Medecin,
            ));
        }catch(Exception $pe){echo 'ERREUR : ' . $pe->getMessage();}
    }

    function ModifyMedecin(){
        try{
            $req = $this->dbConfig->getPDO()->prepare(
                'UPDATE medecin SET 
                civilite = :civilite, 
                nom = :nom, 
                prenom = :prenom
                WHERE Id_Medecin = :Id_Medecin');

            $req->execute(array(
                'Id_Medecin' => $this->Id_Medecin,
                'civilite' => $this->civilite,
                'nom' => $this->nom,
                'prenom' => $this->prenom,
            ));

        }catch(Exception $pe){echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function getAllMedecin(){
        try {
            $req = $this->dbConfig->getPDO()->prepare('SELECT * FROM medecin');
            $req->execute();
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            
        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }
    
    public function getMedecinById(){
        try {    
            $req = $this->dbConfig->getPDO()->prepare('SELECT * FROM medecin WHERE Id_Medecin = :id');
            $req->execute([':id' => $this->getId()]);
            $result = $req->fetch(PDO::FETCH_ASSOC);
            // var_dump($result);
            return $result;
        } catch(Exception $pe) {
            echo 'ERREUR : ' . $pe->getMessage();
        }
    }

    public function idMedecinHasRdv($Id_Medecin)
    {
        try {
            $req = $this->dbConfig->getPDO()->prepare('SELECT Id_Medecin FROM rdv WHERE Id_Medecin = :Id_Medecin');
            $req->execute(array(
                ':Id_Medecin' => $Id_Medecin
            ));
            $result = $req->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                return true; // L'ID existe
            } else {
                return false; // L'ID n'existe pas
            }
        } catch (PDOException $pe) {
            echo 'ERREUR : ' . $pe->getMessage();
            return false; // En cas d'erreur, retourne false
        }
    }
    
    function isReferent($Id_Medecin)
    {
        try {
            $req = $this->dbConfig->getPDO()->prepare('SELECT medecin_referent FROM usager WHERE medecin_referent = :medecin_referent');
            $req->execute(array(
                ':medecin_referent' => $Id_Medecin
            ));
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
    
            if (count($result) > 0) {
                return true; // L'ID existe
            } else {
                return false; // L'ID n'existe pas
            }
        } catch (PDOException $pe) {
            echo 'ERREUR : ' . $pe->getMessage();
            return false; // En cas d'erreur, retourne false
        }
    }
    
    public function setNom($nom){
        $this->nom = $nom;
    }
    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }
    public function setCivilite($civilite){
        $this->civilite = $civilite;
    }
    public function setId($Id_Medecin){
        $this->Id_Medecin = $Id_Medecin;
    }

    public function getNom(){
        return $this->nom;
    }
    public function getPrenom(){
        return $this->prenom;
    }
    public function getCivilite(){
        return $this->civilite;
    }
    public function getId(){
        return $this->Id_Medecin;
    }
}
?>