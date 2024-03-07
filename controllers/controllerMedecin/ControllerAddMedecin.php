<?php

require_once '../../models/DbConfig.php';
require_once '../../models/Medecin.php';

function checkInputToAddMedecin($data) {
    if (!isset($data['civilite']) || !isset($data['nom']) || !isset($data['prenom'])) {
        http_response_code(400);
        echo json_encode(array("status" => "error", "message" => "Tous les champs sont obligatoires."));
        exit;
    }
}

function setCommandToAddMedecin($data) {
    $medecin = new Medecin();
    $medecin->setPrenom($data['prenom']);
    $medecin->setNom($data['nom']);
    $medecin->setCivilite($data['civilite']);

    return $medecin;
}

$data = json_decode(file_get_contents("php://input"), true);

try {
    checkInputToAddMedecin($data);
    $medecin = setCommandToAddMedecin($data);
    $medecin->AddMedecin();

    echo json_encode(array("status" => "success", "message" => "Medecin ajoute avec succes.", "status_code" => http_response_code(200)));
} catch (Exception $e) {
    echo json_encode(array("status" => "error", "message" => "Une erreur c est produite : " , "status_code" => http_response_code(500) , $e->getMessage()));
}
?>
