<?php
    include_once '../../cors.php';
    require_once("../../models/Usager.php");
    require_once '../../JwtVerifier.php';

    try {
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                $usager = new Usager();
                $allUsager = $usager->getAllUsager();
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
        deliver_response(200, "Succès : La liste des usagers a été récupérée.", $allUsager);

    } catch (Exception $e) {
        deliver_response(500, "Echec : La liste des usagers n'a pas été récupérée.",$e->getMessage());
    }

?>