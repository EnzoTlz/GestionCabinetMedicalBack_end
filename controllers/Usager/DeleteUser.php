<?php
    require_once '../Objects/DbConfig.php';
    require_once '../Objects/Usager.php';

    checkInputToDelete($_POST);
    $commandToDelete = setCommandDeleteUser($_POST);
    $commandToDelete->DeleteUser();
    header('Location: ../../front_end/Usagers.php?success=3');

    function checkInputToDelete($POST){
        if (!isset($POST['user_id'])) {
            exceptions_error_handler('user_id null');
        }
    }

    function exceptions_error_handler($message) {
        throw new ErrorException($message);
    }
    
    function setCommandDeleteUser($POST){
        $commandDeleteUserToReturn = new Usager();
        $commandDeleteUserToReturn->setId($POST['user_id']);

        return $commandDeleteUserToReturn;
    }
?>
