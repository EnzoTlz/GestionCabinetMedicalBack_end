<?php
    include_once '../../cors.php';
    require_once("../../models/Usager.php");
    require_once '../../JwtVerifier.php';

    function CheckInputModifyusager() {
        if (!isset($_GET['id'])) {
            deliver_response(400, "Echec : Id non renseigné.",null);
            exit;
        }
    }

    function setModifyUsagerCommand($data){
        $idUsager = $_GET['id'];

        $usager = new Usager();
        $usager->setId($idUsager);
        $usagerExistant = $usager->getUsagerByID($idUsager); //recupere le usager avec l'id
        if($usagerExistant === false){
            deliver_response(400, "Echec : Id de l'usager introuvable .", $_GET['id']);
            return false;
        }else{
            // Check si certain champs sont vide -> si oui on laisse les champs existant
            $prenom = isset($data['prenom']) ? $data['prenom'] : $usagerExistant["prenom"];
            $nom = isset($data['nom']) ? $data['nom'] : $usagerExistant["nom"];
            $civilite = isset($data['civilite']) ? $data['civilite'] : $usagerExistant["civilite"];
            $adresse = isset($data['adresse']) ? $data['adresse'] : $usagerExistant["adresse"];
            $sexe = isset($data['sexe']) ? $data['sexe'] : $usagerExistant["sexe"];
            $code_postal = isset($data['code_postal']) ? $data['code_postal'] : $usagerExistant["code_postal"];
            $ville = isset($data['ville']) ? $data['ville'] : $usagerExistant["ville"];
            $lieu_nais = isset($data['lieu_nais']) ? $data['lieu_nais'] : $usagerExistant["lieu_nais"];
            $date_nais = isset($data['date_nais']) ? $data['date_nais'] : $usagerExistant["date_nais"];
            $num_secu = isset($data['num_secu']) ? $data['num_secu'] : $usagerExistant["num_secu"];
            $medecin_referent = isset($data['medecin_referent']) ? $data['medecin_referent'] : $usagerExistant["medecin_referent"];
            
            $usager->setId($idUsager);
            $usager->setCivilite($civilite);
            $usager->setNom($nom);
            $usager->setPrenom($prenom);    
            $usager->setAdresse($adresse);       
            $usager->setDateNaissance($date_nais);     
            $usager->setLieuNaissance($lieu_nais); 
            $usager->setSexe($sexe);     
            $usager->setVille($ville);    
            $usager->setCodePostal($code_postal);
            $usager->setNumeroSecuriteSocial($num_secu);
            $usager->setMedecinReferent($medecin_referent);

            return $usager;
        }  
    }

    try {
        $jwt = get_bearer_token();
        if(!empty($jwt)){
            $JwtIsValid = verify_jwt($jwt);
            if($JwtIsValid){
                $data = json_decode(file_get_contents("php://input"), true); 

                CheckInputModifyusager($data);
                $usager = setModifyusagerCommand($data);
                if ($usager != false){
                    $usager->Modifyusager();
                    deliver_response(200, "Succès : Usager bien modifié .", $usager);
                }
            }else{
                deliver_response(401, "Echec : Jwt non valide .", $jwt);
            }
        }
    } catch (Exception $e) {
        deliver_response(500, "Echec : Usager non modifié .", $e->getMessage());
    }


?>