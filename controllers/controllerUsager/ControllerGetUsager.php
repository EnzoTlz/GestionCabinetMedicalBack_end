<?php

    require_once("../../models/Usager.php");

    function checkInputToGetUsager() {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Id non trouvée."));
            
            exit;
        }
    }

    function setCommandToGetUsager($id) {
        $usager = new Usager();
        $usager->setId($id);

        return $usager;
    }

    try {
        checkInputToGetUsager();
        $usager = setCommandToGetUsager($_GET['id']);
        $usagerById = $usager->getUsagerByID($_GET['id']);
        if(!$usagerById){
            $usager->deliver_response(500, "Echec : Médecin non trouvé .", false);
        }else{
            $usager->deliver_response(200, "Succès : Médecin bien trouvé .", $usagerById);
        }

    } catch (Exception $e) {
        $medecin->deliver_response(500, "Echec : Médecin non trouvé .", $e->getMessage());
    }


?>  