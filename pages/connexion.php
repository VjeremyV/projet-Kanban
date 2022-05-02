<?php 
include_once(__DIR__.'/../src/fonctions/formulaire.php');
try {
    $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
    if(isset($_POST['mail']) && isset($_POST['mdp'])){
        if(validForm($_POST['mail'])){
            $mdp = crypt($_POST['mdp'], CRYPT_SHA512);
            $recupUser = $dbh->prepare('select * from utilisateur WHERE mail_utilisateur = :mail AND password_utilisateur =:password');
            if($recupUser->execute(['mail' => $_POST['mail'], 'password' => $mdp])){

                $connexion = $recupUser->fetchAll($fetchMode = PDO::FETCH_NAMED);
                
                if($recupUser->rowCount() > 0){
                    session_start();
                    $_SESSION['mail']=$_POST['mail'];
                    $_SESSION['id']= $connexion[0]['id_utilisateur_utilisateur'];
                    $_SESSION['nom'] = $connexion[0]['nom_utilisateur'];
                    $_SESSION['prenom'] = $connexion[0]['prenom_utilisateur'];
                    $_SESSION['photo'] = $connexion[0]['photo_utilisateur'];
                    header('location: ./pages/projets.php?page=encours');      
                } else {
                echo "<p>erreur vous êtes mauvais</p>";
            }
        } else {
            echo "<p>entrez un mail valide!!!</p>";
        }
    } else {
        echo "Une erreur de connexion à la base de données est survenu";
    }
    }
}
catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>