<?php
    include_once '../../cors.php';
    require_once '../../models/Rendez_vous.php';
    require_once '../../JwtVerifier.php';

    function CheckInputModifyRdv($data) {
        $rendezVous = new Rendez_vous();
        if (!isset($data['id_usager']) || !isset($data['id_medecin']) || !isset($data['date_consult']) || !isset($data['heure_consult']) || !isset($data['duree_consult'])){
            deliver_response(400, "Echec : Tous les champs sont obligatoires.",null);
            exit;
        }
        $UsagerExist = $rendezVous->idExistsUsager($data['id_usager']);
        if(!$UsagerExist){
            deliver_response(404, "Echec : Id de l'usager introuvable .", $data['id_usager']);
            exit;
        }
        $MedecinExist = $rendezVous->idExistsMedecin($data['id_medecin']);
        if(!$MedecinExist){
            deliver_response(404, "Echec : Id du médecin introuvable .", $data['id_medecin']);
            exit;
        }
        if(!isset($_GET['id'])){
            deliver_response(400, "Echec : Id non renseignée .",null);
            exit;
        }
    }
    function setModifyRdvCommand($data){

        $rdv = new Rendez_vous();
        $rdvExistant = $rdv->getRdvById($_GET['id']); //recupere du rdv avec l'id
        if($rdvExistant === false){
            deliver_response(404, "Echec : Id du rendez_vous introuvable .", $_GET['id']);
            return false;
        }else{
            // Check si certain champs sont vide -> si oui on laisse les champs existant

            $id_usager = isset($data['id_usager']) ? $data['id_usager'] : $rdvExistant["id_usager"];
            $id_medecin = isset($data['id_medecin']) ? $data['id_medecin'] : $rdvExistant["id_medecin"];
            $date_rdv = isset($data['date_consult']) ? $data['date_consult'] : $rdvExistant["date_rdv"];
            $heure_rdv = isset($data['heure_consult']) ? $data['heure_consult'] : $rdvExistant["heure_rdv"];
            $duree_rdv = isset($data['duree_consult']) ? $data['duree_consult'] : $rdvExistant["duree_rdv"];
           
            $rdv->setIdRdv($_GET['id']);
            $rdv->setIdUsager($id_usager);
            $rdv->setMedecinChoseForRdv($id_medecin);
            $rdv->setDateRdv($date_rdv);
            $rdv->setHeureRdv($heure_rdv);
            $rdv->setDureeRdv($duree_rdv);

            return $rdv;
        }
    }

    try {
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                $rdv = new Rendez_vous();
                $data = json_decode(file_get_contents("php://input"), true); 
                CheckInputModifyRdv($data);
                $rdv = setModifyRdvCommand($data);

                if ($rdv != false){
                    $collisions = $rdv->CheckColisionRdv($rdv->getMedecinChoseForRdv(), $rdv->getIdRdv(), $rdv->getDateRdv(), $rdv->getHeureRdv(), $rdv->getDureeRdv());
                    if(!$collisions){
                        $rdv->ModifyRdv();// check
                        deliver_response(200, "Succès : Rendez-vous bien modifié .", $data);
                    }else{
                        deliver_response(409, "Echec : Colision entre les rendez vous :", $_GET['id']);

                    }
                }
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
    } catch (Exception $e) {
        deliver_response(500, "Echec : Rendez-vous non modifié .", $e->getMessage());

    }


?>