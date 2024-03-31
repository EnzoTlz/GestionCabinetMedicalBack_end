<?php
    include_once '../../cors.php';
    require_once("../../models/Rendez_vous.php");
    require_once '../../JwtVerifier.php';

    function checkInputToDeleteRdv() {
        if (!isset($_GET['id'])) {
            $rendezVous = new Rendez_vous();
            $rendezVous->deliver_response(404, "Echec : Id non renseignée .",null);
            exit;
        }
    }
    function setDeleteRdvCommand() {
        $idRdv = $_GET['id'];

        $rdv = new Rendez_vous();
        $rdv->setIdRdv($idRdv);
        $rdvExistant = $rdv->getRdvById($idRdv); //recupere le medecin avec l'id
        if($rdvExistant === false){
            $rdv->deliver_response(404, "Echec : Id de la consultation introuvable :", $_GET['id']);
            return false;
        }else{
            return $rdv;
        }
    }

    try{
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                checkInputToDeleteRdv();
                $rdv = setDeleteRdvCommand();
                if ($rdv != false){
                    $rdv->DeleteRdv();
                    $rdv->deliver_response(200, "Succès : Consultation bien supprimé .", $_GET);
                }
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
    } catch (Exception $e) {
        $rdv->deliver_response(500, "Echec : Consultation non supprimé .", $e->getMessage());
    }

?>
