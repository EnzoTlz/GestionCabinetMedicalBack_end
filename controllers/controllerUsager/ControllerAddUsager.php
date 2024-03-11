<?php

    require_once '../../models/Usager.php';

    function checkInputToAddUser($data) {
        if (!isset($data['civilite']) || !isset($data['nom']) || !isset($data['prenom']) || !isset($data['adresse']) || !isset($data['date_naissance']) || !isset($data['lieu_naissance']) || !isset($data['numero_securite_social']) || !isset($data['medecin_referent'])){
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Tous les champs sont obligatoires."));
            
            exit;
        }
    }

    function setCommandAddUser($POST){
        $commandAddUserToReturn = new Usager();
        
        $commandAddUserToReturn->setCivilite($POST['civilite']);
        $commandAddUserToReturn->setNom($POST['nom']);
        $commandAddUserToReturn->setPrenom($POST['prenom']);
        $commandAddUserToReturn->setAdresse($POST['adresse']);
        $commandAddUserToReturn->setDateNaissance($POST['date_naissance']);
        $commandAddUserToReturn->setLieuNaissance($POST['lieu_naissance']);
        $commandAddUserToReturn->setNumeroSecuriteSocial($POST['numero_securite_social']);
        $commandAddUserToReturn->setMedecinReferent($POST['medecin_referent']);
        return $commandAddUserToReturn;
    }

    try {
        $data = json_decode(file_get_contents("php://input"), true);
        var_dump($data);
        checkInputToAddUser($data);
        $commandAddUser = setCommandAddUser($data);
        $commandAddUser->addUser();
        $commandAddUser->deliver_response(200, "Succès : Utilisateur bien ajoutée .", $data);

    } catch (Exception $e) {
        $commandAddUser->deliver_response(500, "Echec : Utilisateur bien non ajoutée .", $e->getMessage());
    }

?>  

