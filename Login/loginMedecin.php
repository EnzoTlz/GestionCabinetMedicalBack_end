<?php

require_once '../Objects/DbConfig.php';
require_once '../Objects/Medecin.php';
require_once 'login.php';

    checkInputToLoginMedecin($_POST);
    $commandToLoginMedecin = setCommandToLoginMedecin($_POST);
    $commandToLoginMedecin->CheckMedecinExist();

    function checkInputToLoginMedecin($POST){

        if(!isset($POST['nom'])){
            exceptions_error_handler('nom pas fait');
        }

        if(!isset($POST['prenom'])){
            exceptions_error_handler('prenom pas fait');
        }
    }
    function exceptions_error_handler($message) {
        throw new ErrorException($message);
    }
    function setCommandToLoginMedecin($POST){
        $commandToLoginMedecinToReturn = new Medecin();
        $commandToLoginMedecinToReturn->setPrenom($POST['prenom']);
        $commandToLoginMedecinToReturn->setNom($POST['nom']);

        return $commandToLoginMedecinToReturn;
    }
?>





