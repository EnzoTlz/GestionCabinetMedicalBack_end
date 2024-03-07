<?php

    require_once '../Objects/DbConfig.php';
    require_once '../Objects/Usager.php';

    checkInputToAddUser($_POST);
    $commandAddUser = setCommandAddUser($_POST);
    $commandAddUser->addUser();
    header('Location: ../../front_end/Usagers.php?success=1');




    function checkInputToAddUser($POST){
        if(!isset($POST['civilite'])){
            exceptions_error_handler('civilite null');
        }

        if(!isset($POST['nom'])){
            exceptions_error_handler('nom null');
        }

        if(!isset($POST['prenom'])){
            exceptions_error_handler('prenom null');
        }
        
        if(!isset($POST['adresse'])){
            exceptions_error_handler('adresse null');
        }

        if(!isset($POST['date_naissance'])){
            exceptions_error_handler('date_naissance null');
        }

        if(!isset($POST['lieu_naissance'])){
            exceptions_error_handler('lieu_naissance null');
        }

        if(!isset($POST['numero_securite_social'])){
            exceptions_error_handler('numero_securite_social null');
        }
        if(!isset($POST['medecin_referent'])){
            exceptions_error_handler('medecin référent null');
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



    function exceptions_error_handler($message) {
        throw new ErrorException($message);
    }

?>  