<?php
    include_once '../../cors.php';
    require_once '../../models/Statistique.php';
    require_once '../../JwtVerifier.php';

    try{
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                $statistique = new Statistique();
                $infoMedecin = $statistique->PrintAllNameMedecinAndAllHours();
                deliver_response(200, "Succès : Statistiques bien récupérées.", $infoMedecin);
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
    }catch(Exception $e){   
        deliver_response(500, "Echec : Statistiques non récupérées.", $e->getMessage());
    }

?>