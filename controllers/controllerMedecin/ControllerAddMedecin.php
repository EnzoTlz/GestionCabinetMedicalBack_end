<?php
    include_once '../../cors.php';
    require_once '../../models/Medecin.php';
    require_once '../../JwtVerifier.php';

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
        $retour = new Medecin();

        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            var_dump($JwtIsValid);
        }


        $data = json_decode(file_get_contents("php://input"), true);
        checkInputToAddMedecin($data);
        $medecin = setCommandToAddMedecin($data);
        $medecin->AddMedecin();
        $retour->deliver_response(201, "Succès : Médecin bien ajoutée .", $data);

    } catch (Exception $e) {
        $retour->deliver_response(500, "Echec : Médecin bien non ajoutée .", $e->getMessage());
    }
?>
