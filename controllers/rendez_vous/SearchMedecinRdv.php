<?php
require_once '../Objects/dbConfig.php';
require_once '../Objects/Rendez_vous.php';

checkInputToSearchRdv($_POST);
$commandSearchRdv = setCommandSearchRdv($_POST);
$commandSearchRdv->SearchRdvByMedecin($commandSearchRdv->getMedecinChoseForRdv());
header('Location: ../../front_end/Consultations.php');

function checkInputToSearchRdv($POST){
    if(!isset($POST['medecin_selectionner'])){
        exceptions_error_handler('id medecin null');
    }
}

function setCommandSearchRdv($POST){
    $commandSearchRdvToReturn = new Rendez_vous();
    $commandSearchRdvToReturn->setmedecinChoseForRdv($POST['medecin_selectionner']);

    return $commandSearchRdvToReturn;
}

function exceptions_error_handler($message) {
    throw new ErrorException($message);
}
?>
