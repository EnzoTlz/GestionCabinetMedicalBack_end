<?php
    include_once '../../cors.php';
    require_once('../../models/Statistique.php');
    require_once '../../JwtVerifier.php';

    try{
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                $statistique = new Statistique();
                $nbFemme = $statistique->getNbFemme();
                $nbHomme = $statistique->getNbHomme();
                $getNbHommeMoins25Ans = $statistique->getNbHommeMoins25Ans();
                $getNbFemmeMoins25Ans = $statistique->getNbFemmeMoins25Ans();
                $getNbHommeEntre25et50Ans = $statistique->getNbHommeEntre25et50Ans();
                $getNbFemmeEntre25et50Ans = $statistique->getNbFemmeEntre25et50Ans();
                $getNbHommePlus50Ans = $statistique->getNbHommePlus50Ans();
                $getNbFemmePlus50Ans = $statistique->getNbFemmePlus50Ans();

                $stats = array(
                    "nb femme" => $nbFemme[0], 
                    "nb homme" => $nbHomme[0] , 
                    "nb homme moins 25 ans" => $getNbHommeMoins25Ans[0], 
                    "nb femme moins 25 ans" => $getNbFemmeMoins25Ans[0], 
                    "nb homme entre 25 et 50 ans" => $getNbHommeEntre25et50Ans[0], 
                    "nb femme entre 25 et 50 ans" => $getNbFemmeEntre25et50Ans[0], 
                    "nb homme plus 50 ans" => $getNbHommePlus50Ans[0], 
                    "nb femme plus 50 ans" => $getNbFemmePlus50Ans[0]
                );
                deliver_response(200, "Succès : Statistiques bien récupérées.", $stats);
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
    }catch(Exception $e){
        deliver_response(500, "Echec : Statistiques non récupérées.", $e->getMessage());
    }
?>