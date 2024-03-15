<?php
    include_once '../../cors.php';
    require_once("../../models/Usager.php");

    function checkInputToGetUsager() {
        $usager = new Usager();
        if (!isset($_GET['id'])) {
            $usager->deliver_response(400, "Echec : Id non renseigné.",null);
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
            $usager->deliver_response(500, "Echec : usager non trouvé .", false);
        }else{
            $usager->deliver_response(200, "Succès : usager bien trouvé .", $usagerById);
        }

    } catch (Exception $e) {
        $medecin->deliver_response(500, "Echec : usager non trouvé .", $e->getMessage());
    }


?>  