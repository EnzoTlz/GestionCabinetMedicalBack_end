<?php
    include_once '../../cors.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204);
    exit();
} 
?>
