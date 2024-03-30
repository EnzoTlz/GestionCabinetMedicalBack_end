<?php

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
        return $headers;
    }

    function get_bearer_token(){
        $headers = get_authorization_header();
        $retour = new Medecin();
        if(!empty($headers)){
            if(preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        $retour->deliver_response(401, "Echec : JWT non trouvé .", null);
        exit;
    }

    function verify_jwt($jwt) {
        $url = "https://authapigestionmedical.alwaysdata.net/authAPI/Index.php";
        $ch = curl_init($url);
        
        $cookie = "usertoken=" . $jwt;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPGET, true); 
        curl_setopt($ch, CURLOPT_COOKIE, $cookie); 
        
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new Exception($error);
        }

        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $responseCode == 200;
    }

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
?>
