<?php
    include_once '../../cors.php';
    require_once("../../models/Medecin.php");
    require_once '../../JwtVerifier.php';
    function checkInputToGetMedecin() {
        $medecin = new Medecin();
        if (!isset($_GET['id'])) {
            deliver_response(400, "Echec : Id non renseigné.",null);
            exit;
        }
    }

    function setCommandToGetMedecin() {
        $idMedecin = $_GET['id'];

        $medecin = new Medecin();
        $medecin->setId($idMedecin);
        $medecinExistant = $medecin->getMedecinById(); //recupere le medecin avec l'id
        if($medecinExistant === false){
            deliver_response(404, "Echec : Id du médecin introuvable .", $idMedecin);
            return false;
        }else{
            $medecin->setId($idMedecin);
            return $medecin;
        }
    }

    try {
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                checkInputToGetMedecin();
                $medecin = setCommandToGetMedecin();
                if ($medecin != false){
                    $medecinById = $medecin->getMedecinById();
                    deliver_response(200, "Succès : Médecin bien trouvé .", $medecinById);
                }
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
    } catch (Exception $e) {
        deliver_response(500, "Echec : Médecin non trouvé .", $e->getMessage());
    }


?>  