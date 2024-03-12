<?php

    require_once 'DbConfig.php';
    require_once 'Usager.php';
    class Rendez_vous {

        private DbConfig $dbConfig;
        public Usager $usager;
        private $nom;
        private $prenom;
        private $Id_Usager;
        private $date_rdv;
        private $duree_rdv;
        private $heure_rdv;
        private $medecin_choose;
        
    public function __construct(){
        $this->dbconfig = DbConfig::getDbConfig();
        $this->usager = new Usager();
    
    }

    public function SearchUserForRDV($numero_securite_social)
    {
        try {
            $req = $this->dbconfig->getPDO()->prepare('SELECT u.Id_Usager, u.civilite, u.nom, u.prenom, u.adresse, u.date_naissance, u.lieu_naissance, u.numero_securite_social, u.medecin_referent
                FROM usager u
                WHERE u.numero_securite_social = :numero_securite_social');
            $req->execute(array(
                ':numero_securite_social' => $numero_securite_social,
            ));
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $this->usager->setId($row['Id_Usager']);
                $this->usager->setCivilite($row['civilite']);
                $this->usager->setNom($row['nom']);
                $this->usager->setPrenom($row['prenom']);
                $this->usager->setDateNaissance($row['date_naissance']);
                $this->usager->setAdresse($row['adresse']);
                $this->usager->setLieuNaissance($row['lieu_naissance']);
                $this->usager->setNumeroSecuriteSocial($row['numero_securite_social']);
                $this->usager->setMedecinReferent($row['medecin_referent']);
            }
        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage(); }
    }
    

    public function getMedecinById($Id_Medecin)
    {
        try {
            $req = $this->dbconfig->getPDO()->prepare('SELECT Id_Medecin, nom,prenom FROM medecin WHERE Id_Medecin = :Id_Medecin');
            $req->execute(array(
                ':Id_Medecin' => $Id_Medecin
            ));
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function getNomPrenomMedecin()
    {
        try {
            $req = $this->dbconfig->getPDO()->prepare('SELECT Id_Medecin, nom, prenom FROM medecin');
            $req->execute();
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function sortMedecinReferentFirst($listeMedecins){
        $listeMedecinReturn = array();
        $medecinReferent = $this->getMedecinById($this->usager->getMedecinReferent());
        array_push($listeMedecinReturn,$medecinReferent[0]);
        foreach ($listeMedecins as $medecin) {
            if ($this->usager->getMedecinReferent() !=  $medecin['Id_Medecin']){
                array_push($listeMedecinReturn,$medecin);
            }
        }
        return $listeMedecinReturn;
    }
    public function getUsager(){
        return $this->usager;
    }
    //ADD RDV
    public function addRdv(){
        try{
            $req = $this->dbconfig->getPDO()->prepare('INSERT INTO rdv (duree_rendez_vous , date_rendez_vous , Id_Medecin , Id_Usager,heure_rendez_vous) 
            VALUES (:duree_rdv , :date_rdv , :Id_Medecin , :Id_Usager, :heure_rdv)');

            $req->execute(array(
                'duree_rdv' => $this->duree_rdv,
                'date_rdv' => $this->date_rdv,
                'Id_Medecin' => $this->medecin_choose,
                'Id_Usager' => $this->Id_Usager,
                'heure_rdv' =>$this->heure_rdv,

            ));
        }catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function getAllRdv(){
        try{
            $req = $this->dbconfig->getPDO()->prepare('SELECT id_rendez_vous, duree_rendez_vous , date_rendez_vous , Id_Medecin , Id_Usager , heure_rendez_vous FROM rdv ORDER BY date_rendez_vous');
            $req->execute();
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}

    }

    public function getModifyRdv(){
        try{
            $req = $this->dbconfig->getPDO()->prepare('SELECT * FROM rdv WHERE id_rendez_vous = :id_rendez_vous');
            $req->execute();
            return $req;
        }catch(Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function DeleteRdv(){
        try{
            $req = $this->dbconfig->getPDO()->prepare(
                'DELETE FROM rdv
                WHERE id_rendez_vous = :id_rendez_vous');
    
            $req->execute(array(
                'id_rendez_vous' => $this->id_rendez_vous,
            ));
            
        }catch(Exception $pe){echo 'ERREUR : ' . $pe->getMessage();}
    }
    public function ModifyRdv(){
        try {
            $req = $this->dbconfig->getPDO()->prepare(
                'UPDATE rdv SET
                Date_rendez_vous = :dateRdv,
                Duree_rendez_vous = :dureeRdv,
                Id_Medecin = :idMedecin,
                Id_Usager = :idUsager,
                Heure_rendez_vous = :heureRdv   
                WHERE Id_rendez_vous = :idRdv'
            );
    
            $req->execute(array(
                'dateRdv' => $this->date_rdv,
                'dureeRdv' => $this->duree_rdv,
                'idMedecin' => $this->medecin_choose,
                'idUsager' => $this->Id_Usager,
                'heureRdv' => $this->heure_rdv,
                'idRdv' => $this->id_rendez_vous
            ));
        } catch(Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }
    
    public function SearchRdvByMedecin($medecin_selectionner){
        try {
            $req = $this->dbconfig->getPDO()->prepare('SELECT id_rendez_vous, nom_patient, prenom_patient, numero_securite_social, duree_rendez_vous, date_rendez_vous, Id_Medecin, Id_Usager ,heure_rendez_vous
            FROM rdv 
            WHERE Id_Medecin = :medecin_selectionner
            ORDER BY date_rendez_vous');
            $req->bindValue(':medecin_selectionner', $medecin_selectionner, PDO::PARAM_INT); 
    
            $req->execute();
            return $req;
        } catch (Exception $pe) {
            echo 'ERREUR : ' . $pe->getMessage();
        }
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
            $req = $this->dbconfig->getPDO()->prepare('SELECT id_rendez_vous, nom_patient, prenom_patient, numero_securite_social, duree_rendez_vous, date_rendez_vous, Id_Medecin, Id_Usager ,heure_rendez_vous FROM rdv WHERE Id_Usager = :IdUsager');
            $req->bindValue(':IdUsager', $Id_Usager, PDO::PARAM_INT); 
            $req->execute();

            return $req;
        } catch (Exception $pe) {
            echo 'ERREUR : ' . $pe->getMessage();
        }
    }
    
    public function getMedecinIDByNameAndFristName($nom,$prenom){
        try {
            $req = $this->dbconfig->getPDO()->prepare('SELECT Id_Medecin, nom,prenom FROM medecin WHERE nom = :nom AND prenom = :prenom');
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
            $req = $this->dbconfig->getPDO()->prepare('SELECT id_rendez_vous, nom_patient, prenom_patient, numero_securite_social, duree_rendez_vous, date_rendez_vous, Id_Medecin, Id_Usager ,heure_rendez_vous FROM rdv WHERE Id_Medecin = :IdMedecin');
            $req->bindValue(':IdMedecin', $Id_Medecin, PDO::PARAM_INT); 
            $req->execute();

            return $req;
        } catch (Exception $pe) {
            echo 'ERREUR : ' . $pe->getMessage();
        }
    }

    function convertMinutesToHoursMinutes($minutes) {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        return $hours . ' h ' . $remainingMinutes . ' min';
    }
    

    public function CheckColisionRdv($id_medecin, $id_rendez_vous_to_ignore, $date_rdv, $heure_rdv, $duree_rdv) {
        try {
            $req = $this->dbconfig->getPDO()->prepare('
                SELECT * 
                FROM rdv 
                WHERE Id_Medecin = :IdMedecin 
                AND date_rendez_vous = :date_rdv 
                and (:id_rendez_vous IS NULL OR id_rendez_vous != :id_rendez_vous)
            ');
    
            $req->bindValue(':IdMedecin', $id_medecin, PDO::PARAM_INT); 
            $req->bindValue(':date_rdv', $date_rdv);
            $req->bindValue(':id_rendez_vous', $id_rendez_vous_to_ignore, PDO::PARAM_INT);
            $req->execute();
            

            $allrdv = $req->fetchAll(PDO::FETCH_ASSOC);
            if(sizeof($allrdv) == 0 ){
                return false;
            }

            $start_rdv_program_timestamp = $this->convertToTimestamp($date_rdv, $heure_rdv,0);
            $end_rdv_program_timestamp = $this->convertToTimestamp($date_rdv, $heure_rdv,$duree_rdv); 
            
            foreach($allrdv as $rdv){
                $debutRdv = $this->convertToTimestamp($rdv["Date_rendez_vous"], $rdv["Heure_rendez_vous"], '0');
                $finRdv =  $this->convertToTimestamp($rdv["Date_rendez_vous"], $rdv["Heure_rendez_vous"], $rdv['Duree_rendez_vous']);

                if($start_rdv_program_timestamp < $finRdv && $end_rdv_program_timestamp > $debutRdv){
                    return  true;
                }
            }   
            return false;
        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }
    function convertDureeIntoHour($pDuree){
        return gmdate('H:i:s', $pDuree * 60);
    }
    function convertToTimestamp($date, $time, $duration) {
        $dateTime = $date . ' ' . $time;
        $timestamp = strtotime($dateTime);
        $timestamp += $duration * 60;
    
        return $timestamp;
    }   
    //GET RDV BY ID
    public function getRdvById(){
        try {    
            $req = $this->dbconfig->getPDO()->prepare('SELECT * FROM rdv WHERE Id_rendez_vous = :id');
            $req->execute([':id' => $this->getIdRdv()]);
            $result = $req->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch(Exception $pe) {
            echo 'ERREUR : ' . $pe->getMessage();
        }
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

    
    public function setmedecinChoseForRdv($medecin_choose){
        $this->medecin_choose = $medecin_choose;
    }
    public function setDateRdv($date_rdv){
        $this->date_rdv = $date_rdv;
    }
    public function setDureeRdv($duree_rdv){
        $this->duree_rdv = $duree_rdv;
    }
    public function setIdUsager($Id_Usager){
        $this->Id_Usager = $Id_Usager;
    }
    public function setIdRdv($id_rendez_vous){
        $this->id_rendez_vous = $id_rendez_vous;
    }
    public function setHeureRdv($heure_rdv){
        $this->heure_rdv = $heure_rdv;
    }


    public function getIdRdv() {
        return $this->id_rendez_vous;
    }
    public function getDateRdv() {
        return $this->date_rdv;
    }
    public function getDureeRdv() {
        return $this->duree_rdv;
    }
    public function getMedecinChoseForRdv() {
        return $this->medecin_choose;
    }
    public function getIdUsager() {
        return $this->Id_Usager;
    }
    public function getHeureRdv(){
        return $this->heure_rdv;
    }
}
?>