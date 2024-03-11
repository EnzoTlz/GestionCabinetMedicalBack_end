<?php
    require_once '../../models/Rendez_vous.php';
    
    try {
        $rdv = new Rendez_vous();
        $allrdv = $rdv->getAllRdv();
        
        $rdv->deliver_response(200, "Succès : La liste des consultations a été récupérée.", $allrdv);

    } catch (Exception $e) {
        $rdv->deliver_response(500, "Echec : La liste des consultations n'a pas été récupérée.",$e->getMessage());
    }

?>
