<?php
    require_once '../Objects/Medecin.php';
    require_once '../Objects/DbConfig.php';
    CheckInputModifyMedecin($_POST);
    $commandToModifyMedecin = setModifyMedecinCommand($_POST);
    $commandToModifyMedecin->ModifyMedecin();
    header('Location: ../../front_end/Médecins.php?success=2');

    function CheckInputModifyMedecin($POST){

        if(!isset($POST['Id_Medecin'])){
            exceptions_error_handler('Id_Medecin pas fait');
        }
        if(!isset($POST['nom'])){
            exceptions_error_handler('nom pas fait');
        }
        if(!isset($POST['prenom'])){
            exceptions_error_handler('prenom pas fait');
        }
        if(!isset($POST['civilite'])){
            exceptions_error_handler('civilite pas fait');
        }
    }
    
    function exceptions_error_handler($message) {
        throw new ErrorException($message);
    }
    function setModifyMedecinCommand($POST){
        $commandToModifyMedecinToReturn = new Medecin();
        $commandToModifyMedecinToReturn->setNom($POST['nom']);
        $commandToModifyMedecinToReturn->setPrenom($POST['prenom']);
        $commandToModifyMedecinToReturn->setCivilite($POST['civilite']);
        $commandToModifyMedecinToReturn->setId($POST['Id_Medecin']);
        return $commandToModifyMedecinToReturn;
    }
?>