<?php
require_once '../Objects/DbConfig.php';
require_once '../Objects/Rendez_vous.php';

checkInputToCheckRdv($_POST);
$commandCheckRdv = setCommandCheckRdv($_POST);
$commandCheckButtonClicked = CheckButtonClicked($_POST);

try {
    if ($commandCheckButtonClicked === "m") {
        $url = '../../front_end/rdv/ModifyRdv.php?' . http_build_query([
            'id_rendez_vous' => $commandCheckRdv->getIdRdv(),
            'date_rendez_vous' => $commandCheckRdv->getDateRdv(),
            'duree_rendez_vous' => $commandCheckRdv->getDureeRdv(),
            'Id_Medecin' => $commandCheckRdv->getMedecinChoseForRdv(),
            'Id_Usager' => $commandCheckRdv->getIdUsager(),
            'heure_rendez_vous' => $commandCheckRdv->getHeureRdv(),
        ]);
        header('Location: ' . $url);
    } elseif ($commandCheckButtonClicked === "s") {
        $commandCheckRdv->DeleteRdv();
        header('Location: ../../front_end/Consultations.php?success=1');

    } else {
        exceptions_error_handler('Bouton non reconnu');
    }
} catch (Exception $e) {echo 'Erreur : ' . $e->getMessage();}



function checkInputToCheckRdv($POST)
{
    if (!isset($POST['Id_Usager'])) {
        exceptions_error_handler('id user null');
    }
    if (!isset($POST['Id_Medecin'])) {
        exceptions_error_handler('Id_Medecin null');
    }
    if (!isset($POST['date_rendez_vous'])) {
        exceptions_error_handler('date_rendez_vous null');
    }
    if (!isset($POST['duree_rendez_vous'])) {
        exceptions_error_handler('duree_rdv null');
    }
    if (!isset($POST['id_rendez_vous'])) {
        exceptions_error_handler('id rdv null');
    }
    if(!isset($POST['heure_rendez_vous'])){
        exceptions_error_handler('heure_rdv null');
    }
    
}

function setCommandCheckRdv($POST)
{
    $commandCheckRevToReturn = new Rendez_vous();

    $commandCheckRevToReturn->setIdRdv($POST['id_rendez_vous']);
    $commandCheckRevToReturn->setDateRdv($POST['date_rendez_vous']);
    $commandCheckRevToReturn->setDureeRdv($POST['duree_rendez_vous']);
    $commandCheckRevToReturn->setmedecinChoseForRdv($POST['Id_Medecin']);
    $commandCheckRevToReturn->setIdUsager($POST['Id_Usager']);
    $commandCheckRevToReturn->setHeureRdv($POST['heure_rendez_vous']);

    return $commandCheckRevToReturn;
}

function CheckButtonClicked($POST)
{
    $commandCheckButtonClicked = "";
    if (isset($_POST['Modifier'])) {
        $commandCheckButtonClicked = "m";
    } elseif (isset($_POST['Supprimer'])) {
        $commandCheckButtonClicked = "s";
    }
    return $commandCheckButtonClicked;
}

function exceptions_error_handler($message)
{
    throw new Exception($message);
}
?>
