    <?php
        include_once '../../cors.php';
        require_once '../../models/Rendez_vous.php';
        
        function checkInputToAddRdv($data) {
            $rendezVous = new Rendez_vous();
            if (!isset($data['id_usager']) || !isset($data['id_medecin']) || !isset($data['date_consult']) || !isset($data['heure_consult']) || !isset($data['duree_consult'])){
                $rendezVous->deliver_response(400, "Echec : Tous les champs sont obligatoires.",null);
                exit;
            }
            $UsagerExist = $rendezVous->idExistsUsager($data['id_usager']);
            if(!$UsagerExist){
                $rendezVous->deliver_response(404, "Echec : Id de l'usager introuvable .", $data['id_usager']);
                exit;
            }
            $MedecinExist = $rendezVous->idExistsMedecin($data['id_medecin']);
            if(!$MedecinExist){
                $rendezVous->deliver_response(404, "Echec : Id du médecin introuvable .", $data['id_medecin']);
                exit;
            }
        }

        function setCommandAddRdv($data){
            $commandAddRdvToReturn = new Rendez_vous();
            
            $commandAddRdvToReturn->setDateRdv($data['date_consult']);
            $commandAddRdvToReturn->setHeureRdv($data['heure_consult']);
            $commandAddRdvToReturn->setDureeRdv($data['duree_consult']);
            $commandAddRdvToReturn->setmedecinChoseForRdv($data['id_medecin']);
            $commandAddRdvToReturn->setIdUsager($data['id_usager']);
            return $commandAddRdvToReturn;
        }

        try{
            $rendezVous = new Rendez_vous();
            $data = json_decode(file_get_contents("php://input"), true);
            checkInputToAddRdv($data);
            $commandAddRdv = setCommandAddRdv($data);
            $collisions = $rendezVous->CheckColisionRdv($commandAddRdv->getMedecinChoseForRdv(), null, $commandAddRdv->getDateRdv(), $commandAddRdv->getHeureRdv(), $commandAddRdv->getDureeRdv());

            if (!$collisions) {
                $commandAddRdv->AddRdv();
                $rendezVous->deliver_response(201, "Success : Rendez vous bien ajouté .", $data);
            } else {
                $rendezVous->deliver_response(409, "Echec : Colision entre les rendez vous .", $data);
            }
        }catch(Exception $e){
            $rendezVous->deliver_response(500, "Echec : Rendez non ajouté .", $e->getMessage());
        }

    ?>  
