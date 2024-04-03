<?php
    require_once( "../../cors.php");
    require_once("../../models/Medecin.php");
    require_once '../../JwtVerifier.php';

    try {
        $medecin = new Medecin();

        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                $allMedecin = $medecin->getAllMedecin();
                deliver_response(200, "Succès : La liste des médecins a été récupérée.", $allMedecin);
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
    } catch (Exception $e) {
        deliver_response(500, "Echec : La liste des médecins n'a pas été récupérée.",$e->getMessage());
    }

?>