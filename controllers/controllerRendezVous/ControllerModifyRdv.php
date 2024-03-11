<?php
    require_once '../../models/Rendez_vous.php';

    function CheckInputModifyRdv() {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array("status" => "error", "message" => "Id non trouvé."));
            
            exit;
        }
    }
    function setModifyRdvCommand($data){
        $idRdv = $_GET['id'];

        $rdv = new Rendez_vous();
        $rdv->setIdRdv($idRdv);
        $rdvExistant = $rdv->getRdvById(); //recupere le medecin avec l'id
        if($rdvExistant === false){
            $rdv->deliver_response(400, "Echec : Id du rendez_vous introuvable .", $_GET['id']);
            return false;
        }else{
            // Check si certain champs sont vide -> si oui on laisse les champs existant
            $id_usager = isset($data['id_usager']) ? $data['id_usager'] : $rdvExistant["id_usager"];
            $id_medecin = isset($data['id_medecin']) ? $data['id_medecin'] : $rdvExistant["id_medecin"];
            $date_rdv = isset($data['date_consult']) ? $data['date_consult'] : $rdvExistant["date_rdv"];
            $heure_rdv = isset($data['heure_consult']) ? $data['heure_consult'] : $rdvExistant["heure_rdv"];
            $duree_rdv = isset($data['duree_consult']) ? $data['duree_consult'] : $rdvExistant["duree_rdv"];

            $rdv->setIdUsager($id_usager);
            $rdv->setMedecinChoseForRdv($id_medecin);
            $rdv->setDateRdv($date_rdv);
            $rdv->setHeureRdv($heure_rdv);
            $rdv->setDureeRdv($duree_rdv);

            return $rdv;
        }
    }

    try {
        $rdv = new Rendez_vous();
        $erreur = new Rendez_vous(); // SI rdv == false alors erreur ==> déclare un objet au cas ou
        $data = json_decode(file_get_contents("php://input"), true); 

        CheckInputModifyRdv();
        $rdv = setModifyRdvCommand($data);

        if ($rdv != false){
            $collisions = $rdv->CheckColisionRdv($rdv->getMedecinChoseForRdv(), $rdv->getIdRdv(), $rdv->getDateRdv(), $rdv->getHeureRdv(), $rdv->getDureeRdv());
            if(!$collisions){
                $rdv->ModifyRdv();// check
                $rdv->deliver_response(200, "Succès : Rendez-vous bien modifié .", $data);
            }else{
                $erreur->deliver_response(500, "Echec : Colision entre les rendez vous :", $_GET['id']);

            }
        }
    } catch (Exception $e) {
        $rdv->deliver_response(500, "Echec : Rendez-vous non modifié .", $e->getMessage());

    }


?>