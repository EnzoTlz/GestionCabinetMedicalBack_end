<?php
require_once 'DbConfig.php';
class Usager
{
    private DbConfig $dbconfig;
    private $Id_Usager;
    private $civilite;
    private $nom;
    private $prenom;
    private $adresse;
    private $date_naissance;
    private $lieu_naissance;
    private $numero_securite_social;
    private $medecin_referent;
    private $code_postal;
    private $sexe;
    private $ville;

    public function __construct(){
        $this->dbconfig = DbConfig::getDbConfig();
    }
    
    
    //+++++++++++++++++++++++++++++++++++++++++++++++++++AJOUT USER+++++++++++++++++++++++++++++++++++++++++++++++
    public function addUser()
    {
        try {
            $req = $this->dbconfig->getPDO()->prepare('INSERT INTO usager (civilite ,nom, prenom, adresse, date_nais,lieu_nais, num_secu,medecin_referent , sexe, code_postal, ville) 
            VALUES (:civilite,:nom, :prenom, :adresse, :date_nais,:lieu_nais, :num_secu, :medecin_referent , :sexe, :code_postal, :ville)');

            $date_naissance_format = date('Y-m-d', strtotime($this->date_naissance));

            $req->execute(array(
                'nom' => $this->nom,
                'civilite' => $this->civilite,
                'prenom' => $this->prenom,
                'adresse' => $this->adresse,
                'date_nais' => $date_naissance_format,
                'lieu_nais' => $this->lieu_naissance,
                'num_secu' => $this->numero_securite_social,
                'medecin_referent' => $this->medecin_referent,
                'code_postal' => $this->code_postal,
                'sexe' => $this->sexe,
                'ville' => $this->ville,

            ));

        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function DeleteUsager(){
        try{
            $req = $this->dbconfig->getPDO()->prepare(
                'DELETE FROM usager
                WHERE Id_Usager = :user_id');
    
            $req->execute(array(
                'user_id' => $this->Id_Usager,
            ));
            
        }catch(Exception $pe){echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function ModifyUsager(){
        try{
            $req = $this->dbconfig->getPDO()->prepare(
            'UPDATE usager SET 
                civilite = :civilite,
                nom = :nom,
                prenom = :prenom,
                adresse = :adresse,
                date_nais = :date_naissance,
                lieu_nais = :lieu_naissance,
                num_secu = :numero_securite_social,
                medecin_referent = :medecin_referent,
                code_postal = :code_postal,
                sexe = :sexe,
                ville = :ville
                WHERE Id_Usager = :Id_Usager');

            $req->execute(array(
                'Id_Usager' => $this->Id_Usager,
                'civilite' => $this->civilite,
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'adresse' => $this->adresse,
                'date_naissance' => $this->date_naissance,
                'lieu_naissance' => $this->lieu_naissance,
                'numero_securite_social' => $this->numero_securite_social,
                'medecin_referent' => $this->medecin_referent,
                'code_postal' => $this->code_postal,
                'sexe' => $this->sexe,
                'ville' => $this->ville,

            ));


            
        }catch(Exception $pe){echo 'ERREUR : ' . $pe->getMessage();}
    } 

    // GET USAGER BY ID
    public function getUsagerByID($Id_Usager){
        try {
            $req = $this->dbconfig->getPDO()->prepare('SELECT * FROM usager WHERE Id_Usager = :IdUsager');
            $req->bindValue(':IdUsager', $Id_Usager, PDO::PARAM_INT);
            $req->execute();
    
            $result = $req->fetch(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (Exception $pe) {
            echo 'ERREUR : ' . $pe->getMessage();
        }
    }

    //UTILISER POUR GETALL
    public function getAllUsager(){
        try {
            $req = $this->dbconfig->getPDO()->prepare('SELECT * FROM usager');
            $req->execute();
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            
        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function idUsagerHasRdv($Id_Usager)
    {
        try {
            $req = $this->dbconfig->getPDO()->prepare('SELECT Id_Usager FROM rdv WHERE Id_Usager = :Id_Usager');
            $req->execute(array(
                ':Id_Usager' => $Id_Usager
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
    //+++++++++++++++++++++++++++++++++++++++++++++++++++SETTER+++++++++++++++++++++++++++++++++++++++++++++++
    public function setId($Id_Usager){
        $this->Id_Usager = $Id_Usager;
    }
    public function setCivilite($civ){
        $this->civilite = $civ;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }

    public function setAdresse($adresse){
        $this->adresse = $adresse;
    }

    public function setDateNaissance($date_naissance){
        $this->date_naissance = $date_naissance;
    }

    public function setLieuNaissance($lieu_naissance){
        $this->lieu_naissance = $lieu_naissance;
    }

    public function setSexe($sexe){
        $this->sexe = $sexe;
    }

    public function setVille($ville){
        $this->ville = $ville;
    }
    
    public function setCodePostal($code_postal){
        $this->code_postal = $code_postal;
    }

    public function setNumeroSecuriteSocial($numero_securite_social){
        $this->numero_securite_social = $numero_securite_social;
    }
    public function setMedecinReferent($medecin_referent){
        $this->medecin_referent = $medecin_referent;
    }
    public function getIdUsager(){
        return $this->Id_Usager;
    }
    
    public function getCivilite(){
        return $this->civilite;
    }
    
    public function getNom(){
        return $this->nom;
    }
    
    public function getPrenom(){
        return $this->prenom;
    }
    
    public function getAdresse(){
        return $this->adresse;
    }
    
    public function getDateNaissance(){
        return $this->date_naissance;
    }
    
    public function getLieuNaissance(){
        return $this->lieu_naissance;
    }
    
    public function getNumeroSecuriteSocial(){
        return $this->numero_securite_social;
    }
    
    public function getMedecinReferent(){
        return $this->medecin_referent;
    }
    public function getCodePostal(){
        return $this->code_postal;
    }
    public function getSexe(){
        return $this->sexe;
    }
    public function getVille(){
        return $this->ville;
    }
}
?>
