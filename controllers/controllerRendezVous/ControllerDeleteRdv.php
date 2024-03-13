<?php
    include_once '../../cors.php';
    require_once("../../models/Rendez_vous.php");


    function checkInputToDeleteRdv() {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Id non renseigné."));
            
            exit;
        }
    }
    function setDeleteRdvCommand() {
        $idRdv = $_GET['id'];

        $rdv = new Rendez_vous();
        $rdv->setIdRdv($idRdv);
        $rdvExistant = $rdv->getRdvById(); //recupere le medecin avec l'id
        if($rdvExistant === false){
            $rdv->deliver_response(400, "Echec : Id de la consultation introuvable :", $_GET['id']);
            return false;
        }else{
            return $rdv;
        }
    }

    try{
        checkInputToDeleteRdv();
        $rdv = setDeleteRdvCommand();
        if ($rdv != false){
            $rdv->DeleteRdv();
            $rdv->deliver_response(200, "Succès : Consultation bien supprimé .", $_GET);
        }
    } catch (Exception $e) {
        $rdv->deliver_response(500, "Echec : Consultation non supprimé .", $e->getMessage());
    }

?>
