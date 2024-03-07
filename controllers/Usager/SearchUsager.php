<?php

    require_once '../Objects/DbConfig.php';
    require_once '../Objects/Usager.php';
    checkInputToSearchUser($_POST);
    $commandSearchUser = setCommandSearchUser($_POST);
    $commandSearchUser->SearchUser($_POST['context']);

    function checkInputToSearchUser($POST){
        if(!isset($POST['nom'])){
            exceptions_error_handler('nom pas fait');
        }
        if(!isset($POST['prenom'])){
            exceptions_error_handler('prenom pas fait');
        }
        if(!isset($POST['numero_securite_social'])){
            exceptions_error_handler('numero_securite_social pas fait');
        }
    }

    function exceptions_error_handler($message) {
        throw new ErrorException($message);
    }

    function setCommandSearchUser($POST){
        $commandSearchUserToReturn = new Usager();
        
        $commandSearchUserToReturn->setNom($POST['nom']);
        $commandSearchUserToReturn->setPrenom($POST['prenom']);
        $commandSearchUserToReturn->setNumeroSecuriteSocial($POST['numero_securite_social']);
        return $commandSearchUserToReturn;
    }

?>  