<?php
// jwt_verifier.php
function verify_jwt($jwt) {
    $url = "https://authapigestionmedical.alwaysdata.net/authAPI/Index.php";
    $ch = curl_init($url);
    
    // Set options
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $jwt));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true); // Specify that you want a POST request
    curl_setopt($ch, CURLOPT_POSTFIELDS, []); // You can set post fields if necessary
    
    // Execute the request
    $result = curl_exec($ch);
    
    // Check if any error occurred
    if (curl_errno($ch)) {
        curl_close($ch);
        throw new Exception(curl_error($ch));
    }

    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($responseCode == 200) {
        // Token is valid
        return true;
    } else {
        // Token is not valid
        return false;
    }
}
?>
