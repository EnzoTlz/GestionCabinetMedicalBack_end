<?php
    require_once("../../models/Medecin.php");


    function CheckInputModifyMedecin($data) {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Id non trouvé."));
            
            exit;
        }

    }
    function setModifyMedecinCommand($data){
        $idMedecin = $_GET['id'];

        $medecin = new Medecin();
        $medecin->setId($idMedecin);
        $medecinExistant = $medecin->getMedecinById(); //recupere le medecin avec l'id
        if($medecinExistant === false){
            $medecin->deliver_response(400, "Echec : Id du médecin introuvable .", $_GET['id']);
            return false;
        }else{
            // Check si certain champs sont vide -> si oui on laisse les champs existant
            $prenom = isset($data['prenom']) ? $data['prenom'] : $medecinExistant["prenom"];
            $nom = isset($data['nom']) ? $data['nom'] : $medecinExistant["nom"];
            $civilite = isset($data['civilite']) ? $data['civilite'] : $medecinExistant["civilite"];
    
            $medecin->setId($idMedecin);
            $medecin->setNom($nom);
            $medecin->setPrenom($prenom);
            $medecin->setCivilite($civilite);

            return $medecin;
        }

        
    }

    try {

        $data = json_decode(file_get_contents("php://input"), true); 

        CheckInputModifyMedecin($data);
        $medecin = setModifyMedecinCommand($data);
        if ($medecin != false){
            $medecin->ModifyMedecin();
            $medecin->deliver_response(200, "Succès : Médecin bien modifié .", $data);
        }


    } catch (Exception $e) {
        $medecin->deliver_response(500, "Echec : Médecin non modifié .", $e->getMessage());

    }


?>