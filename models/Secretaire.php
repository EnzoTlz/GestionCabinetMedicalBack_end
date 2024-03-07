<?php
require_once 'DbConfig.php';
class Secretaire{
    private DbConfig $dbConfig;
    private $nom;
    private $prenom;
    private $mdp;
    private $id;

    public function __construct(){
        $this->dbConfig = DbConfig::getDbConfig();
    
}

    public function CheckSecretaireExist(){
        try {
            $req = $this->dbConfig->getPDO()->prepare('SELECT * FROM Secretaire WHERE mots_de_passe = :mdp AND prenom = :prenom');

            $req->execute(array(
                'prenom' => $this->prenom,
                'mdp' => $this->mdp,
            ));
            $secretaire = $req->fetch();
            if ($secretaire) {
                header('Location: ../../front_end/Consultations.php');
                exit;
            } else {
                header('Location: ../../front_end/index.html');
                exit;
            }
    
        } catch (Exception $pe) {echo 'ERREUR : ' . $pe->getMessage();}
    }

    public function setNom($nom){
        $this->nom = $nom;
    }
    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }
    public function setMdp($mdp){
        $this->mdp = $mdp;
    }
    public function setId($id){
        $this->id = $id;
    }
}
?>