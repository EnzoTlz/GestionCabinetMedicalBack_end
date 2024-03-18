<?php
    include_once '../../cors.php';
    require_once("../../models/Medecin.php");

    function checkInputToDeleteMedecin() {
        $medecin = new Medecin();
        if (!isset($_GET['id'])) {
            $medecin->deliver_response(400, "Echec : Id non renseigné.",null);
            exit;
        }
    }
    function checkIfMedecinHasRdv(){
        $medecin = new Medecin();
        $hasRdv = $medecin->idMedecinHasRdv(($_GET['id']));
        if($hasRdv){
            $medecin->deliver_response(401, "Echec : Suppresion du médecin impossible il a une/des consultations.", $_GET['id']);
            exit;
        }
    }
    function checkIfMedecinIsReferent(){
        $medecin = new Medecin();
        $isReferent = $medecin->isReferent(($_GET['id']));
        if($isReferent){
            $medecin->deliver_response(401, "Echec : Suppresion du médecin impossible il est référent d'un patient.", $_GET['id']);
            exit;
        }
    }
    function setDeleteMedecinCommand() {
        $idMedecin = $_GET['id'];

        $medecin = new Medecin();
        $medecin->setId($idMedecin);
        $medecinExistant = $medecin->getMedecinById(); //recupere le medecin avec l'id
        if($medecinExistant === false){
            $medecin->deliver_response(404, "Echec : Id du médecin introuvable .", $idMedecin);
            return false;
        }else{
            $medecin->setId($idMedecin);
            return $medecin;
        }
    }

    try{
        checkInputToDeleteMedecin();
        checkIfMedecinHasRdv();
        checkIfMedecinIsReferent();
        $medecin = setDeleteMedecinCommand();
        if ($medecin != false){
            $medecin->DeleteMedecin();
            $medecin->deliver_response(200, "Succès : Médecin bien supprimé .", $_GET);
        }
    } catch (Exception $e) {
        $medecin->deliver_response(500, "Echec : Médecin non modifié .", $e->getMessage());
    }

?>
