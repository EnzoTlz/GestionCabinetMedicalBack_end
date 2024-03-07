<?php

    require_once '../Objects/DbConfig.php';
    require_once '../Objects/Medecin.php';
    checkInputToSearchMedecin($_POST);
    $commandSearchUser = setCommandSearchMedecin($_POST);
    $commandSearchUser->SearchMedecin($_POST['context']);

    function checkInputToSearchMedecin($POST){
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

    function setCommandSearchMedecin($POST){
        $commandSearchMedecinToReturn = new Medecin();
        
        $commandSearchMedecinToReturn->setNom($POST['nom']);
        $commandSearchMedecinToReturn->setPrenom($POST['prenom']);
        return $commandSearchMedecinToReturn;
    }

?>  