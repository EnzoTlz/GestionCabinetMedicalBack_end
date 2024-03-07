<?php


    CheckInputLogin($_POST);

    function CheckInputLogin($POST){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(isset($_POST['btnSecretaire'])){
                header('Location: ../../front_end/secretaire/LoginSecretaire.php');
            }
            if(isset($_POST['btnPatient'])){
                header('Location: ../../front_end/usager/LoginUsager.php');
            }
            if(isset($_POST['btnMedecin'])){
                header('Location: ../../front_end/medecin/LoginMedecin.php');
            }
        }
    }
?>