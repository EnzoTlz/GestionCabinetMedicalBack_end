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
    function get_authorization_header(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER['Authorization']);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER['HTTP_AUTHORIZATION']);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        var_dump($headers);
        return $headers;
    }
    
    function get_bearer_token(){
        $headers = get_authorization_header();
        // Vérifiez que les en-têtes ne sont pas vides
        var_dump($headers);
        
        if(!empty($headers)){
            if(preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                // Vérifiez que l'expression régulière a bien trouvé une correspondance
                var_dump($matches);
                return $matches[1];
            }
        }
        return null;
    }
    

    try {
        $retour = new Medecin();
        var_dump(getallheaders());

        echo json_encode(apache_request_headers());

        // $jwt = get_jwt_from_headers();
        $jwt = get_bearer_token();
        var_dump($jwt);
        // if (!$jwt || !verify_jwt($jwt)) {
        //     $retour->deliver_response(401, "Echec : JWT invalide .", $jwt);
        //     exit;
        // }

        $data = json_decode(file_get_contents("php://input"), true);
        checkInputToAddMedecin($data);
        $medecin = setCommandToAddMedecin($data);
        $medecin->AddMedecin();
        $retour->deliver_response(201, "Succès : Médecin bien ajoutée .", $data);

    } catch (Exception $e) {
        $retour->deliver_response(500, "Echec : Médecin bien non ajoutée .", $e->getMessage());
    }
?>
