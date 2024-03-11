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
            $req = $this->dbconfig->getPDO()->prepare('INSERT INTO usager (civilite ,nom, prenom, adresse, date_naissance,lieu_naissance, numero_securite_social,medecin_referent) 
            VALUES (:civilite,:nom, :prenom, :adresse, :date_naissance,:lieu_naissance, :numero_securite_social, :medecin_referent )');

            $req->execute(array(
                'nom' => $this->nom,
                'civilite' => $this->civilite,
                'prenom' => $this->prenom,
                'adresse' => $this->adresse,
                'date_naissance' => $this->date_naissance,
                'lieu_naissance' => $this->lieu_naissance,
                'numero_securite_social' => $this->numero_securite_social,
                'medecin_referent' => $this->medecin_referent,

            ));

        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function SearchUser($context)
    {
        try {
            $req = $this->dbconfig->getPDO()->prepare('SELECT Id_Usager,civilite, nom, prenom, adresse, date_naissance, lieu_naissance, numero_securite_social
            FROM usager WHERE nom = :nom AND prenom = :prenom');
    
            $req->execute(array(
                ':nom' => $this->nom,
                ':prenom' => $this->prenom,
            ));
    
            $result = $req->fetch(PDO::FETCH_ASSOC);
    
            if ($result !== false) {
                if ($context === 'Modify') {
                    $url = '../../front_end/usager/ModifyUsager.php?' . http_build_query($result);
                    header('Location: ' . $url);
                    exit();
                } elseif ($context === 'Delete') {
                    $url = '../../front_end/usager/DeleteUsager.php?' . http_build_query($result);
                    header('Location: ' . $url);
                    exit();
                }
            } else {
                echo 'Aucun utilisateur trouvé.';
            }
        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }
    

    //+++++++++++++++++++++++++++++++++++++++++++++++++++DELETE USER+++++++++++++++++++++++++++++++++++++++++++++++

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
    //+++++++++++++++++++++++++++++++++++++++++++++++++++MODIFICATION USER+++++++++++++++++++++++++++++++++++++++++++++++
    public function ModifyUsager(){
        try{
            $req = $this->dbconfig->getPDO()->prepare(
            'UPDATE usager SET 
                civilite = :form_civilite,
                nom = :form_nom,
                prenom = :form_prenom,
                adresse = :form_adresse,
                date_naissance = :form_date_naissance,
                lieu_naissance = :form_lieu_naissance,
                numero_securite_social = :form_numero_securite_social
                WHERE Id_Usager = :user_id');

            $req->execute(array(
                'user_id' => $this->Id_Usager,
                'form_civilite' => $this->civilite,
                'form_nom' => $this->nom,
                'form_prenom' => $this->prenom,
                'form_adresse' => $this->adresse,
                'form_date_naissance' => $this->date_naissance,
                'form_lieu_naissance' => $this->lieu_naissance,
                'form_numero_securite_social' => $this->numero_securite_social,

            ));


            
        }catch(Exception $pe){echo 'ERREUR : ' . $pe->getMessage();}
    } 

    public function CheckUsagerExist(){
        try{
            $req = $this->dbconfig->getPDO()->prepare('SELECT * FROM usager WHERE nom = :nom AND prenom = :prenom' );

            $req->execute(array(
                'prenom' => $this->prenom,
                'nom' => $this->nom,
            ));

            $usager = $req->fetch();
            if($usager){
                header('Location: ../../front_end/usager/usager.php?nom=' . urlencode($usager['nom']) . '&prenom=' . urlencode($usager['prenom']));
            }else{
                header('Location: ../../front_end/index.html');
            }

        }catch(Exception $pe){echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function getUsagerIDByNameAndFristName($nom,$prenom){
        try {
            $req = $this->dbconfig->getPDO()->prepare('SELECT Id_Usager, nom,prenom FROM usager WHERE nom = :nom AND prenom = :prenom');
            $req->execute(array(
                ':prenom' => $prenom,
                ':nom' => $nom,
            ));
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function getAllRdvUsagerByIdUsager($Id_Usager){
        try {
            $req = $this->dbconfig->getPDO()->prepare('SELECT * FROM rdv WHERE Id_Usager = :IdUsager');
            $req->bindValue(':IdUsager', $Id_Usager, PDO::PARAM_INT);
            $req->execute();

            return $req;
        } catch (Exception $pe) {
            echo 'ERREUR : ' . $pe->getMessage();
        }
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

    public function CheckUsagerExistByNumeroSecuriteSocial($numero_securite_social){
        try{
            $req = $this->dbconfig->getPDO()->prepare('SELECT * FROM usager WHERE numero_securite_social = :numero_securite_social' );
            $req->bindValue(':numero_securite_social', $numero_securite_social, PDO::PARAM_INT);
            $req->execute();
            $result = $req->fetch(PDO::FETCH_ASSOC);
            if($result){
                return true;
            }else{
                return false;
            }

        }catch(Exception $pe){echo 'ERREUR : ' . $pe->getMessage();}
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



    function deliver_response($status_code, $status_message, $data){

        http_response_code($status_code);
        header("Content-Type:application/json; charset=utf-8");
        $response['status_code'] = $status_code;
        $response['status_message'] = $status_message;
        $response['data'] = $data;
        $json_response = json_encode($response);
        if($json_response===false)
            die('json encode ERROR : '.json_last_error_msg());
        echo $json_response;
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
