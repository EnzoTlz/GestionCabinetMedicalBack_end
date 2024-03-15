<?php
    include_once '../../cors.php';
    require_once("../../models/Rendez_vous.php");

    function checkInputToGetRdv() {
        if (!isset($_GET['id'])) {
            $rendezVous = new Rendez_vous();
            $rendezVous->deliver_response(400, "Echec : Id non renseignée .",null);
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
            $rdv->deliver_response(404, "Echec : Consultation non trouvé .", false);
        }else{
            $rdv->deliver_response(200, "Succès : Consultation bien trouvé .", $rdvById);
        }

    } catch (Exception $e) {
        $rdv->deliver_response(500, "Echec : Consultation non trouvé .", $e->getMessage());
    }


?>  