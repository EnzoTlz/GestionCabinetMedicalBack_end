<?php
    include_once '../../cors.php';
    require_once '../../models/Rendez_vous.php';
    require_once '../../JwtVerifier.php';

    try {
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                $rdv = new Rendez_vous();
                $allrdv = $rdv->getAllRdv();
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
        deliver_response(200, "Succès : La liste des consultations a été récupérée.", $allrdv);

    } catch (Exception $e) {
        deliver_response(500, "Echec : La liste des consultations n'a pas été récupérée.",$e->getMessage());
    }

?>
