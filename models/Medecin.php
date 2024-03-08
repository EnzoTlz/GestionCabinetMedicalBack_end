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
//+++++++++++++++++++++++++++++++++++++++++++++++ADD MEDECIN+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

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
//+++++++++++++++++++++++++++++++++++++++++++++++++SEARCH MEDECIN +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function SearchMedecin($context){
    try {    
        $req = $this->dbConfig->getPDO()->prepare('SELECT Id_Medecin, nom, prenom, civilite FROM medecin WHERE nom = :nom AND prenom = :prenom');
        $req->execute(array(
            'nom' => $this->nom,
            'prenom' => $this->prenom,
        ));
        $result = $req->fetch(PDO::FETCH_ASSOC);

        if ($result !== false) {
            if ($context === 'Modify') {
                $url = '../../front_end/medecin/ModifyMedecin.php?' . http_build_query($result);
                header('Location: ' . $url);
                exit();
            } elseif ($context === 'Delete') {
                $url = '../../front_end/medecin/DeleteMedecin.php?' . http_build_query($result);
                header('Location: ' . $url);
                exit();
            }
        } else {
            echo 'Aucun utilisateur trouvé.';
        }
    } catch(Exception $pe){echo 'ERREUR : ' . $pe->getMessage();}
}

//+++++++++++++++++++++++++++++++++++++++++++++++++DELETE MEDECIN +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    function DeleteMedecin(){
        try{
            $req = $this->dbConfig->getPDO()->prepare('DELETE FROM medecin WHERE Id_Medecin = :Id_Medecin');
            $req->execute(array(
                'Id_Medecin' => $this->Id_Medecin,
            ));
        }catch(Exception $pe){echo 'ERREUR : ' . $pe->getMessage();}
    }
//+++++++++++++++++++++++++++++++++++++++++++++++++MODIFY MEDECIN +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

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

    function CheckMedecinExist() {
        try {
            $req = $this->dbConfig->getPDO()->prepare('SELECT * FROM medecin WHERE nom = :nom AND prenom = :prenom');
    
            $req->execute(array(
                'prenom' => $this->prenom,
                'nom' => $this->nom,
            ));
    
            $medecin = $req->fetch();
            if ($medecin) {
                header('Location: ../../front_end/medecin/medecin.php?nom=' . urlencode($medecin['nom']) . '&prenom=' . urlencode($medecin['prenom']));
                exit;
            } else {
                header('Location: ../../front_end/index.html');
                exit;
            }
    
        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }
    public function getMedecinIDByNameAndFristName($nom,$prenom){
        try {
            $req = $this->dbConfig->getPDO()->prepare('SELECT Id_Medecin, nom,prenom FROM medecin WHERE nom = :nom AND prenom = :prenom');
            $req->execute(array(
                ':prenom' => $prenom,
                ':nom' => $nom,
            ));
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function getAllRdvMedecinByIdMedecin($Id_Medecin){
        try {
            $req = $this->dbConfig->getPDO()->prepare('SELECT * FROM rdv WHERE Id_Medecin = :IdMedecin');
            $req->bindValue(':IdMedecin', $Id_Medecin, PDO::PARAM_INT);
            $req->execute();

            return $req;
        } catch (Exception $pe) {
            echo 'ERREUR : ' . $pe->getMessage();
        }
    }

    public function getNameAndFirstNameByID($Id_Medecin){
        try {
            $req = $this->dbConfig->getPDO()->prepare('SELECT nom, prenom FROM medecin WHERE Id_Medecin = :IdMedecin');
            $req->bindValue(':IdMedecin', $Id_Medecin, PDO::PARAM_INT);
            $req->execute();
    
            $result = $req->fetch(PDO::FETCH_ASSOC);
    
            return $result['nom'] . ' ' . $result['prenom'];
        } catch (Exception $pe) {
            echo 'ERREUR : ' . $pe->getMessage();
        }
    }
    


    public function getAllMedecin(){
        try {
            $req = $this->dbConfig->getPDO()->prepare('SELECT * FROM medecin');
            $req->execute();
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
    
            $output = '';
            foreach ($result as $medecin) {
                $output .= '<option value="' . $medecin['Id_Medecin'] . '">' . $medecin['prenom'] . ' ' . $medecin['nom'] . '</option>';
            }
    
            return $output;
        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }
    
//+++++++++++++++++++++++++++++++++++++++++++++++++++SETTER+++++++++++++++++++++++++++++++++++++++++++++++
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