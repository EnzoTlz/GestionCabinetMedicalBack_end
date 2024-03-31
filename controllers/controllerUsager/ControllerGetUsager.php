<?php
    include_once '../../cors.php';
    require_once("../../models/Usager.php");
    require_once '../../JwtVerifier.php';

    function checkInputToGetUsager() {
        if (!isset($_GET['id'])) {
            deliver_response(400, "Echec : Id non renseigné.",null);
            exit;
        }
    }

    function setCommandToGetUsager($id) {
        $usager = new Usager();
        $usager->setId($id);

        return $usager;
    }

    try {
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                checkInputToGetUsager();
                $usager = setCommandToGetUsager($_GET['id']);
                $usagerById = $usager->getUsagerByID($_GET['id']);
                if(!$usagerById){
                    deliver_response(500, "Echec : usager non trouvé .", false);
                }else{
                    deliver_response(200, "Succès : usager bien trouvé .", $usagerById);
                }
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
    } catch (Exception $e) {
        deliver_response(500, "Echec : usager non trouvé .", $e->getMessage());
    }


?>  