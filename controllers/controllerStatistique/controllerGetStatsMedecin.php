<?php

    require_once '../../models/Statistique.php';

    try{
        $statistique = new Statistique();
        $infoMedecin = $statistique->PrintAllNameMedecinAndAllHours();
        $statistique->deliver_response(200, "Succès : Statistiques bien récupérées.", $infoMedecin);
    }catch(Exception $e){   
        $statistique->deliver_response(500, "Echec : Statistiques non récupérées.", $e->getMessage());
    }

?>