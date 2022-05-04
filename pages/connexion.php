<?php
//page de gestion de connexion
include_once(__DIR__ . '/../src/fonctions/formulaire.php');//fichier de fonctions gestion de formulaire
try {
    $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
    if (isset($_POST['email']) && isset($_POST['mdp'])) {
        if (validForm($_POST['email'])) { //ValidForm voir dans fichier fonctions/formulaire.php
            $recupUser = $dbh->prepare('select * from utilisateur WHERE mail_utilisateur = :mail');
            if ($recupUser->execute(['mail' => $_POST['email']])) {
                $res = $recupUser->fetchAll($fetchMode = PDO::FETCH_NAMED);
                if(count($res) > 0){ //si on nous renvoi un élément correspondant
                    if (password_verify($_POST['mdp'], $res[0]['password_utilisateur'])) {
                        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
                    if ($recupUser->rowCount() > 0) {
                        session_start();
                        $_SESSION['mail'] = $_POST['email'];
                        $_SESSION['id'] = $res[0]['id_utilisateur_utilisateur'];
                        $_SESSION['nom'] = $res[0]['nom_utilisateur'];
                        $_SESSION['prenom'] = $res[0]['prenom_utilisateur'];
                        $_SESSION['photo'] = $res[0]['photo_utilisateur'];
                        header('location: ./pages/projets.php?page=encours');  
                    }
                }       
                else {
                    echo '<span class="mt-3 alert alert-danger">erreur vous êtes mauvais</span>';
                }
            } else {
                echo '<span class="mt-3 alert alert-danger">erreur vous êtes mauvais</span>';

            }
        }
        } else {
            echo '<span lass="mt-3 alert alert-danger">entrez un mail valide!!!</span>';
        }
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
