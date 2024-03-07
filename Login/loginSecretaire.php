<?php

require_once '../Objects/DbConfig.php';
require_once '../Objects/Secretaire.php';
require_once 'login.php';

    checkInputToLoginSecretaire($_POST);

    $commandToLoginSecretaire = setCommandToLoginSecretaire($_POST);
    $commandToLoginSecretaire->CheckSecretaireExist();

    function checkInputToLoginSecretaire($POST){

        if(!isset($POST['mdp'])){
            exceptions_error_handler('mdp pas fait');
        }

        if(!isset($POST['prenom'])){
            exceptions_error_handler('prenom pas fait');
        }
    }
    function exceptions_error_handler($message) {
        throw new ErrorException($message);
    }
    function setCommandToLoginSecretaire($POST){
        $commandToLoginSecretaireToReturn = new Secretaire();
        $commandToLoginSecretaireToReturn->setPrenom($POST['prenom']);
        $commandToLoginSecretaireToReturn->setMdp($POST['mdp']);

        return $commandToLoginSecretaireToReturn;
    }
?>





