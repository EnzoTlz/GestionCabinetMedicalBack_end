<?php
    include_once '../../cors.php';
    require_once("../../models/Rendez_vous.php");

    function checkInputToGetRdv() {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "id non trouvé."));
            
            exit;
        }
    }

    function setCommandToGetRdv($id) {
        $rdv = new Rendez_vous();
        $rdv->setIdRdv($id);

        return $rdv;
    }

    try {
        checkInputToGetRdv();
        $rdv = setCommandToGetRdv($_GET['id']);
        $rdvById = $rdv->getRdvById();
        if(!$rdvById){
            $rdv->deliver_response(500, "Echec : Consultation non trouvé .", false);
        }else{
            $rdv->deliver_response(200, "Succès : Consultation bien trouvé .", $rdvById);
        }

    } catch (Exception $e) {
        $rdv->deliver_response(500, "Echec : Consultation non trouvé .", $e->getMessage());
    }


?>  