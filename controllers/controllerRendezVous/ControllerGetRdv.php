<?php
    include_once '../../cors.php';
    require_once("../../models/Rendez_vous.php");
    require_once '../../JwtVerifier.php';

    function checkInputToGetRdv() {
        if (!isset($_GET['id'])) {
            deliver_response(400, "Echec : Id non renseignée .",null);
            exit;
        }
    }

    function setCommandToGetRdv($id) {
        $rdv = new Rendez_vous();
        $rdv->setIdRdv($id);

        return $rdv;
    }

    try {
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                checkInputToGetRdv();
                $rdv = setCommandToGetRdv($_GET['id']);
                $rdvById = $rdv->getRdvById($_GET['id']);
                if(!$rdvById){
                    deliver_response(404, "Echec : Consultation non trouvé .", false);
                }else{
                    deliver_response(200, "Succès : Consultation bien trouvé .", $rdvById);
                }
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
    } catch (Exception $e) {
        deliver_response(500, "Echec : Consultation non trouvé .", $e->getMessage());
    }


?>  