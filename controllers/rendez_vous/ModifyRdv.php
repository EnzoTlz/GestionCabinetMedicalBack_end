<?php
    require_once '../Objects/DbConfig.php';
    require_once '../Objects/Rendez_vous.php';

    $rendezVous = new Rendez_vous();

    checkInputToAddRdv($_POST);
    $commandModifyRdv = setCommandModifyRdv($_POST);
    $collisions = $rendezVous->CheckColisionRdv($commandModifyRdv->getMedecinChoseForRdv(), $commandModifyRdv->getIdRdv(), $commandModifyRdv->getDateRdv(), $commandModifyRdv->getHeureRdv(), $commandModifyRdv->getDureeRdv());

    if (!$collisions) {
        $commandModifyRdv->ModifyRdv();

        header('Location: ../../front_end/Consultations.php?success=3');
    } else {
        header('Location: ../../front_end/Consultations.php?echec=1');
    }



    function checkInputToAddRdv($POST){
        var_dump($POST);
        if(!isset($POST['idMedecin'])){
            exceptions_error_handler('id user null');
        }
        if(!isset($POST['idUsager'])){
            exceptions_error_handler('Id_Usager null');
        }
        if(!isset($POST['dateRdv'])){
            exceptions_error_handler('date_rdv null');
        }
        if(!isset($POST['dureeRdv'])){
            exceptions_error_handler('duree_rdv null');
        }
        if(!isset($POST['idRdv'])){
            exceptions_error_handler('idRdv null');
        }
        if(!isset($POST['heureRdv'])){
            exceptions_error_handler('heureRdv null');
        }
    }

    function setCommandModifyRdv($POST){
        $commandModifyRdvToReturn = new Rendez_vous();
        
        $commandModifyRdvToReturn->setDateRdv($POST['dateRdv']);
        $commandModifyRdvToReturn->setDureeRdv($POST['dureeRdv']);
        $commandModifyRdvToReturn->setmedecinChoseForRdv($POST['idMedecin']);
        $commandModifyRdvToReturn->setIdUsager($POST['idUsager']);
        $commandModifyRdvToReturn->setIdRdv($POST['idRdv']);
        $commandModifyRdvToReturn->setHeureRdv($POST['heureRdv']);
        return $commandModifyRdvToReturn;
    }


    function exceptions_error_handler($message) {
        throw new ErrorException($message);
    }

?>  
?>