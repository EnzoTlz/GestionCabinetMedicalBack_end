<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");

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


try {
    $data = json_decode(file_get_contents("php://input"), true);
    checkInputToAddMedecin($data);
    $medecin = setCommandToAddMedecin($data);
    $medecin->AddMedecin();
    $medecin->deliver_response(200, "Succès : Médecin bien ajoutée .", $data);

} catch (Exception $e) {
    $medecin->deliver_response(500, "Echec : Médecin bien non ajoutée .", $e->getMessage());
}
?>
