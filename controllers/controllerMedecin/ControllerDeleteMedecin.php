<?php
    include_once '../../cors.php';
    require_once("../../models/Medecin.php");
    require_once '../../JwtVerifier.php';

    function checkInputToDeleteMedecin() {
        $medecin = new Medecin();
        if (!isset($_GET['id'])) {
            deliver_response(400, "Echec : Id non renseigné.",null);
            exit;
        }
    }
    function checkIfMedecinHasRdv(){
        $medecin = new Medecin();
        $hasRdv = $medecin->idMedecinHasRdv(($_GET['id']));
        if($hasRdv){
            deliver_response(401, "Echec : Suppresion du médecin impossible il a une/des consultations.", $_GET['id']);
            exit;
        }
    }
    function checkIfMedecinIsReferent(){
        $medecin = new Medecin();
        $isReferent = $medecin->isReferent(($_GET['id']));
        if($isReferent){
            deliver_response(401, "Echec : Suppresion du médecin impossible il est référent d'un patient.", $_GET['id']);
            exit;
        }
    }
    function setDeleteMedecinCommand() {
        $idMedecin = $_GET['id'];

        $medecin = new Medecin();
        $medecin->setId($idMedecin);
        $medecinExistant = $medecin->getMedecinById(); //recupere le medecin avec l'id
        if($medecinExistant === false){
            deliver_response(404, "Echec : Id du médecin introuvable .", $idMedecin);
            return false;
        }else{
            $medecin->setId($idMedecin);
            return $medecin;
        }
    }

    try{
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                checkInputToDeleteMedecin();
                checkIfMedecinHasRdv();
                checkIfMedecinIsReferent();
                $medecin = setDeleteMedecinCommand();
                if ($medecin != false){
                    $medecin->DeleteMedecin();
                    $medecin->deliver_response(200, "Succès : Médecin bien supprimé .", $_GET);
                }
            }
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }

    } catch (Exception $e) {
        $medecin->deliver_response(500, "Echec : Médecin non modifié .", $e->getMessage());
    }

?>
