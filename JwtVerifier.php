<?php
// jwt_verifier.php
function verify_jwt($jwt) {
    $url = "https://authapigestionmedical.alwaysdata.net/authAPI/Index.php";
    $ch = curl_init($url);
    
    // Préparer le cookie
    $cookie = "usertoken=" . $jwt;
    
    // Set options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPGET, true); // Utiliser une requête GET
    curl_setopt($ch, CURLOPT_COOKIE, $cookie); // Envoyer le JWT dans un cookie
    
    // Execute the request
    $result = curl_exec($ch);

    // Check if any error occurred
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception($error);
    }

    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Vous pouvez vouloir vérifier également le contenu de $result pour des réponses plus spécifiques de l'API.
    return $responseCode == 200;
}
?>
