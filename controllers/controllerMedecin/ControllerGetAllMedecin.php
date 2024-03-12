<?php
    include_once '../../cors.php';
    require_once("../../models/Medecin.php");

    try {
        $medecin = new Medecin();
        $allMedecin = $medecin->getAllMedecin();
        
        $medecin->deliver_response(200, "Succès : La liste des médecins a été récupérée.", $allMedecin);

    } catch (Exception $e) {
        $medecin->deliver_response(500, "Echec : La liste des médecins n'a pas été récupérée.",$e->getMessage());
    }

?>