<?php

require_once '../Objects/DbConfig.php';
require_once '../Objects/Usager.php';
require_once 'login.php';

    checkInputToLoginUsager($_POST);
    $commandToLoginUsager = setCommandToLoginUsager($_POST);
    $commandToLoginUsager->CheckUsagerExist();

    function checkInputToLoginUsager($POST){

        if(!isset($POST['nom'])){
            exceptions_error_handler('nom null');
        }

        if(!isset($POST['prenom'])){
            exceptions_error_handler('prenom null');
        }
    }
    function exceptions_error_handler($message) {
        throw new ErrorException($message);
    }
    function setCommandToLoginUsager($POST){
        $commandToLoginUsagerToReturn = new Usager();
        $commandToLoginUsagerToReturn->setPrenom($POST['prenom']);
        $commandToLoginUsagerToReturn->setNom($POST['nom']);

        return $commandToLoginUsagerToReturn;
    }
?>





