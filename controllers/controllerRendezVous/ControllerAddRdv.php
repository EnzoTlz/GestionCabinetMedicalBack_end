    <?php
        require_once '../../models/Rendez_vous.php';
        
        function checkInputToAddRdv($data) {
            if (!isset($data['id_usager']) || !isset($data['id_medecin']) || !isset($data['date_consult']) || !isset($data['heure_consult']) || !isset($data['duree_consult'])){
                http_response_code(400);
                echo json_encode(array("status" => "error", "message" => "Tous les champs sont obligatoires."));
                
                exit;
            }
            // VERIFIER SI LES ID MEDECIN ET USAGER EXISTE DANS LA BASE DE DONNEE
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
                $rendezVous->deliver_response(200, "Success : Rendez vous bien ajouté .", $data);
            } else {
                $rendezVous->deliver_response(500, "Echec : Colision entre les rendez vous .", $data);
            }
        }catch(Exception $e){
            $rendezVous->deliver_response(500, "Echec : Rendez non ajouté .", $e->getMessage());
        }

    ?>  
