<?php
    include_once '../../cors.php';
    require_once("../../models/Medecin.php");

    function checkInputToGetMedecin() {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "id non trouvé."));
            
            exit;
        }
    }

    function setCommandToGetMedecin($id) {
        $medecin = new Medecin();
        $medecin->setId($id);

        return $medecin;
    }

    try {
        checkInputToGetMedecin();
        $medecin = setCommandToGetMedecin($_GET['id']);
        $medecinById = $medecin->getMedecinById();
        if(!$medecinById){
            $medecin->deliver_response(500, "Echec : Médecin non trouvé .", false);
        }else{
            $medecin->deliver_response(200, "Succès : Médecin bien trouvé .", $medecinById);
        }

    } catch (Exception $e) {
        $medecin->deliver_response(500, "Echec : Médecin non trouvé .", $e->getMessage());
    }


?>  