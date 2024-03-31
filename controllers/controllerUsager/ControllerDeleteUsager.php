<?php
    include_once '../../cors.php';
    require_once("../../models/Usager.php");
    require_once("../../models/Rendez_vous.php");
    require_once '../../JwtVerifier.php';

    function checkInputToDeleteUsager() {
        $usager = new Usager();
        if (!isset($_GET['id'])) {
            deliver_response(400, "Echec : Id non renseigné.",null);
            exit;
        }
    }
    function checkIfUserHasRdv(){
        $usager = new Usager();
        $hasRdv = $usager->idUsagerHasRdv(($_GET['id']));
        if($hasRdv == true){
            deliver_response(401, "Echec : Suppresion du patient impossible il a une/des consultations.", $_GET['id']);
            exit;
        }
    }
    function setDeleteUsagerCommand() {
        $idUsager = $_GET['id'];

        $usager = new Usager();
        $usager->setId($idUsager);
        $usagerExistant = $usager->getUsagerByID($idUsager); //recupere le medecin avec l'id
        if($usagerExistant === false){
            deliver_response(400, "Echec : Id de l'usager introuvable .", $_GET['id']);
            return false;
        }else{
    
            $usager->setId($idUsager);
            return $usager;
        }
    }

    try{
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                checkInputToDeleteUsager();
                checkIfUserHasRdv();
                $usager = setDeleteUsagerCommand();
                if ($usager != false){
                    $usager->DeleteUsager();
                    deliver_response(200, "Succès : usager bien supprimé .", $_GET);
                }
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
    } catch (Exception $e) {
        deliver_response(500, "Echec : usager non modifié .", $e->getMessage());
    }

?>
