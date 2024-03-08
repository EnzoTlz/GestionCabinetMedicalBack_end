<?php
    require_once("../../models/Medecin.php");

    function deliver_response($status_code, $status_message, $data){

        http_response_code($status_code);
        header("Content-Type:application/json; charset=utf-8");
        $response['status_code'] = $status_code;
        $response['status_message'] = $status_message;
        $response['data'] = $data;
        $json_response = json_encode($response);
        if($json_response===false)
            die('json encode ERROR : '.json_last_error_msg());
        echo $json_response;
    }
        
    try {
        $medecin = new Medecin();
        $allMedecin = $medecin->getAllMedecin();
        
        deliver_response(200, "Voici tous les medecins", $allMedecin);

    } catch (Exception $e) {
        echo json_encode(array("status" => "error", "message" => "Une erreur c est produite : " , "status_code" => http_response_code(500) , $e->getMessage()));
    }

?>