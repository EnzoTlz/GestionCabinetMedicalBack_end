<?php
    include_once '../../cors.php';
    require_once("../../models/Usager.php");


    function checkInputToDeleteUsager() {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Id non renseigné."));
            
            exit;
        }
    }
    function setDeleteUsagerCommand() {
        $idUsager = $_GET['id'];

        $usager = new Usager();
        $usager->setId($idUsager);
        $usagerExistant = $usager->getUsagerByID($idUsager); //recupere le medecin avec l'id
        if($usagerExistant === false){
            $usager->deliver_response(400, "Echec : Id de l'usager introuvable .", $_GET['id']);
            return false;
        }else{
    
            $usager->setId($idUsager);
            return $usager;
        }
    }

    try{
        checkInputToDeleteUsager();
        $usager = setDeleteUsagerCommand();
        if ($usager != false){
            $usager->DeleteUsager();
            $usager->deliver_response(200, "Succès : usager bien supprimé .", $_GET);
        }
    } catch (Exception $e) {
        $usager->deliver_response(500, "Echec : usager non modifié .", $e->getMessage());
    }

?>
