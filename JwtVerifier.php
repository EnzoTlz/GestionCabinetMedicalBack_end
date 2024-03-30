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
    
    // Execute the request
    $result = curl_exec($ch);

    // Debugging output
    var_dump($result);

    // Check if any error occurred
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        var_dump($error); // Display error
        throw new Exception($error);
    }

    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    var_dump($responseCode); // Display HTTP response code

    // Assuming your API returns 200 for valid tokens;
    // you might also want to check the body of the response for more details if your API provides such
    return $responseCode == 200;
}
?>
