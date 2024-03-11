<?php
    require_once("../../models/Usager.php");

    try {
        $usager = new Usager();
        $allUsager = $usager->getAllUsager();
        
        $usager->deliver_response(200, "Succès : La liste des usagers a été récupérée.", $allUsager);

    } catch (Exception $e) {
        $usager->deliver_response(500, "Echec : La liste des usagers n'a pas été récupérée.",$e->getMessage());
    }

?>