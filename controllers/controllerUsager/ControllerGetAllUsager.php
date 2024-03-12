<?php
require_once("../../models/Usager.php");
require_once("../../models/DbConfig.php");

try {
    // Créer une instance de DbConfig
    $dbconfig = DbConfig::getDbConfig();

    // Créer une instance de Usager en passant l'instance de DbConfig comme argument
    $usager = new Usager($dbconfig);

    // Obtenir tous les usagers
    $allUsager = $usager->getAllUsager();
    
    // Retourner une réponse réussie
    $usager->deliver_response(200, "Succès : La liste des usagers a été récupérée.", $allUsager);

} catch (Exception $e) {
    // Retourner une réponse d'erreur avec le message d'exception
    $usager->deliver_response(500, "Echec : La liste des usagers n'a pas été récupérée.", $e->getMessage());
}
?>
