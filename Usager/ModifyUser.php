<?php
    require_once '../Objects/DbConfig.php';
    require_once '../Objects/Usager.php';


    checkInputToModify($_POST);
    $commandToModify = setComandModifyUser($_POST);
    $commandToModify->ModifyUser();
    header('Location: ../../front_end/Usagers.php?success=2');

    function checkInputToModify($POST){
        if(!isset($POST['civilite'])){
            exceptions_error_handler('civilite pas fait');
        }

        if(!isset($POST['form_nom'])){
            exceptions_error_handler('nom pas fait');
        }

        if(!isset($POST['form_prenom'])){
            exceptions_error_handler('prenom pas fait');
        }
        
        if(!isset($POST['form_adresse'])){
            exceptions_error_handler('adresse pas fait');
        }

        if(!isset($POST['form_date_naissance'])){
            exceptions_error_handler('date_naissance pas fait');
        }

        if(!isset($POST['form_lieu_naissance'])){
            exceptions_error_handler('lieu_naissance pas fait');
        }

        if(!isset($POST['form_numero_securite_social'])){
            exceptions_error_handler('numero_securite_social pas fait');
        }
    }

    function exceptions_error_handler($message) {
        throw new ErrorException($message);
    }

    
    function setComandModifyUser($POST){
        $commandModifyUserToReturn = new Usager();
        $commandModifyUserToReturn->setId($POST['user_id']);
        $commandModifyUserToReturn->setCivilite($POST['civilite']);
        $commandModifyUserToReturn->setNom($POST['form_nom']);
        $commandModifyUserToReturn->setPrenom($POST['form_prenom']);
        $commandModifyUserToReturn->setAdresse($POST['form_adresse']);
        $commandModifyUserToReturn->setDateNaissance($POST['form_date_naissance']);
        $commandModifyUserToReturn->setLieuNaissance($POST['form_lieu_naissance']);
        $commandModifyUserToReturn->setNumeroSecuriteSocial($POST['form_numero_securite_social']);
        return $commandModifyUserToReturn;
    }

?>