<?php

require_once '../../model/DbConfig.php';
require_once '../../model/Medecin.php';

// Récupère les données JSON envoyées par la requête POST et les décode
$data = json_decode(file_get_contents("php://input"), true);

// Vous pouvez maintenant utiliser $data au lieu de $_POST
var_dump($data);
checkInputToAddMedecin($data);
$commandToAddMedecin = setCommandToAddMedecin($data);
$commandToAddMedecin->AddMedecin();
//header('Location: ../../front_end/Médecins.php?success=1');

function checkInputToAddMedecin($data){
    if(!isset($data['civilite'])){
        exceptions_error_handler('civilite pas fait');
    }

    if(!isset($data['nom'])){
        exceptions_error_handler('nom pas fait');
    }

    if(!isset($data['prenom'])){
        exceptions_error_handler('prenom pas fait');
    }
}

function exceptions_error_handler($message) {
    throw new ErrorException($message);
}

function setCommandToAddMedecin($data){
    $commandToAddMedecinToReturn = new Medecin();
    $commandToAddMedecinToReturn->setPrenom($data['prenom']);
    $commandToAddMedecinToReturn->setNom($data['nom']);
    $commandToAddMedecinToReturn->setCivilite($data['civilite']);

    return $commandToAddMedecinToReturn;
}
?>
