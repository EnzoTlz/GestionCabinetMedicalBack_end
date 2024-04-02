<?php
<?php
// Autoriser les requêtes provenant de ce domaine
$allowedOrigin = "https://gestionmedicalfront.alwaysdata.net";

// Vérifier si l'en-tête Origin est présent dans la requête
if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] == $allowedOrigin) {
    // Autoriser l'accès depuis ce domaine
    header('Access-Control-Allow-Origin: ' . $allowedOrigin);
    // Autoriser toutes les méthodes HTTP
    header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
    // Autoriser certains autres en-têtes CORS, y compris Authorization
    header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization');
    // Autoriser les cookies à être envoyés sur la demande
    header('Access-Control-Allow-Credentials: true');
}

// Vérifier si la méthode de la requête est OPTIONS
// Si c'est le cas, ne rien faire de plus et simplement terminer le script
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

// Traiter la requête normalement
// Votre code pour répondre à la requête API va ici
?>

?>
