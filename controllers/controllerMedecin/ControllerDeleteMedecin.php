<?php
    include_once '../../cors.php';
    require_once("../../models/Medecin.php");


    function checkInputToDeleteMedecin() {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Id non renseigné."));
            
            exit;
        }
    }
    function setDeleteMedecinCommand() {
        $idMedecin = $_GET['id'];

        $medecin = new Medecin();
        $medecin->setId($idMedecin);
        $medecinExistant = $medecin->getMedecinById(); //recupere le medecin avec l'id
        if($medecinExistant === false){
            $medecin->deliver_response(400, "Echec : Id du médecin introuvable .", $_GET['id']);
            return false;
        }else{
    
            $medecin->setId($idMedecin);
            return $medecin;
        }
    }

    try{
        checkInputToDeleteMedecin();
        $medecin = setDeleteMedecinCommand();
        if ($medecin != false){
            $medecin->DeleteMedecin();
            $medecin->deliver_response(200, "Succès : Médecin bien supprimé .", $_GET);
        }
    } catch (Exception $e) {
        $medecin->deliver_response(500, "Echec : Médecin non modifié .", $e->getMessage());
    }

?>
