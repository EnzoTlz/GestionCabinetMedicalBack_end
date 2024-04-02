<?php
    header("Access-Control-Allow-Origin: https://gestionmedicalfront.alwaysdata.net");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT, PATCH");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header("Access-Control-Allow-Origin: https://gestionmedical.alwaysdata.net");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT, PATCH");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        http_response_code(200);
        exit();
    }
?>
