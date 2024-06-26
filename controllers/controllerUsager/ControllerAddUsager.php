<?php
    include_once '../../cors.php';
    require_once '../../models/Usager.php';
    require_once '../../JwtVerifier.php';

    function checkInputToAddUser($data) {
        $usager = new Usager();
        if (!isset($data['civilite']) || !isset($data['nom']) || !isset($data['prenom']) || !isset($data['adresse']) || !isset($data['date_nais']) || !isset($data['lieu_nais']) || !isset($data['num_secu']) || !isset($data['id_medecin']) || !isset($data['sexe']) || !isset($data['ville']) || !isset($data['code_postal'])){
            deliver_response(400, "Echec : Tous les champs ne sont pas renseigné.",null);
            
            exit;
        }
    }

    function setCommandAddUser($data){
        $usager = new Usager();
        
        $usager->setCivilite($data['civilite']);
        $usager->setNom($data['nom']);
        $usager->setPrenom($data['prenom']);
        $usager->setAdresse($data['adresse']);
        $usager->setDateNaissance($data['date_nais']);
        $usager->setLieuNaissance($data['lieu_nais']);
        $usager->setNumeroSecuriteSocial($data['num_secu']);
        $usager->setMedecinReferent($data['id_medecin']);
        $usager->setSexe($data['sexe']);     
        $usager->setVille($data['ville']);    
        $usager->setCodePostal($data['code_postal']);
        return $usager;
    }

    try {
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                $data = json_decode(file_get_contents("php://input"), true);
                checkInputToAddUser($data);
                $commandAddUser = setCommandAddUser($data);
                $commandAddUser->addUser();
                deliver_response(201, "Succès : Utilisateur bien ajoutée .", $data);
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
    } catch (Exception $e) {
        deliver_response(500, "Echec : Utilisateur bien non ajoutée .", $e->getMessage());
    }

?>  

