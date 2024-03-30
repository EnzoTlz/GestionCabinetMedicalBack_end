<?php
// jwt_verifier.php
function verify_jwt($jwt) {
    $url = "https://authapigestionmedical.alwaysdata.net/authAPI/Index.php";
    $ch = curl_init($url);
    
    // Set options
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $jwt));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true); // La méthode POST est utilisée pour la requête.
    
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
    
    // Retourne true si le code de réponse est 200, indiquant que le JWT est valide.
    return $responseCode == 200;
}
?>
