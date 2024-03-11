<?php

    require_once '../../models/Usager.php';

    function checkInputToAddUser($data) {
        if (!isset($data['civilite']) || !isset($data['nom']) || !isset($data['prenom']) || !isset($data['adresse']) || !isset($data['date_nais']) || !isset($data['lieu_nais']) || !isset($data['num_secu']) || !isset($data['medecin_referent']) || !isset($data['sexe']) || !isset($data['ville']) || !isset($data['code_postal'])){
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Tous les champs sont obligatoires."));
            
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
        $usager->setMedecinReferent($data['medecin_referent']);
        $usager->setSexe($data['sexe']);     
        $usager->setVille($data['ville']);    
        $usager->setCodePostal($data['code_postal']);
        return $usager;
    }

    try {
        $data = json_decode(file_get_contents("php://input"), true);
        checkInputToAddUser($data);
        $commandAddUser = setCommandAddUser($data);
        $commandAddUser->addUser();
        $commandAddUser->deliver_response(200, "Succès : Utilisateur bien ajoutée .", $data);

    } catch (Exception $e) {
        $commandAddUser->deliver_response(500, "Echec : Utilisateur bien non ajoutée .", $e->getMessage());
    }

?>  

