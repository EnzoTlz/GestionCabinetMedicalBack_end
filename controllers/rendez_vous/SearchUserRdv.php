<?php
    session_start();

    require_once '../Objects/DbConfig.php';
    require_once '../Objects/Rendez_vous.php';

    checkInputToSearch($_POST);
    $usagerExist = checkUserExist($_POST['numero_securite_social']);
    if(!$usagerExist){
        header('Location: ../../front_end/Consultations.php?echec=2');
    }else{
        $url = '../../front_end/rdv/AddRdv.php?' . http_build_query([
            'numero_securite_social' => $_POST['numero_securite_social'],
    
        ]);
        header('Location: ' . $url);
        session_write_close();
    }



    function checkInputToSearch($POST){
        if(!isset($POST['numero_securite_social'])){
            exceptions_error_handler('numero_securite_social null');
        }
    }
    function checkUserExist($numero_securite_social){
        $usager = new Usager();
        $exist = $usager->CheckUsagerExistByNumeroSecuriteSocial($numero_securite_social);
        if($exist){
            return true;
        }else{
            return false;
        }
    }



    function exceptions_error_handler($message) {
        throw new ErrorException($message);
    }
?>


