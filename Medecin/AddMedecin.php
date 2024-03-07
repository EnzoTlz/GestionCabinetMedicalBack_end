<?php

require_once '../Objects/DbConfig.php';
require_once '../Objects/Medecin.php';

    checkInputToAddMedecin($_POST);
    $commandToAddMedecin = setCommandToAddMedecin($_POST);
    $commandToAddMedecin->AddMedecin();
    header('Location: ../../front_end/Médecins.php?success=1');

function checkInputToAddMedecin($POST){
    if(!isset($POST['civilite'])){
        exceptions_error_handler('civilite pas fait');
    }

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
function setCommandToAddMedecin($POST){
    $commandToAddMedecinToReturn = new Medecin();
    $commandToAddMedecinToReturn->setPrenom($POST['prenom']);
    $commandToAddMedecinToReturn->setNom($POST['nom']);
    $commandToAddMedecinToReturn->setCivilite($POST['civilite']);

    return $commandToAddMedecinToReturn;
}
?>





