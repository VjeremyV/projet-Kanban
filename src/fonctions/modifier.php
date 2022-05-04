<?php
//mise à jour de la bdd sur la page profil

//mise à jour du nom, prenom, mail
if (isset($_POST['submit'])) {
    $validName = validForm($_POST['name']);//voir la fonction validForm dans le fichier fonctions/formulaire.php
    $validSurname = validForm($_POST['surname']);//voir la fonction validForm dans le fichier fonctions/formulaire.php
    if ($validName && $validSurname) { //voir la fonction validForm dans le fichier fonctions/formulaire.php
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
            $stmt = $dbh->prepare('update utilisateur set `nom_utilisateur`=:nom ,`prenom_utilisateur`=:prenom WHERE `id_utilisateur_utilisateur`=:id');
            if ($stmt->execute(['nom' => $_POST['name'], 'prenom' => $_POST['surname'], 'id' => $_SESSION['id']])) {
                $_SESSION['nom'] = $_POST['name'];
                $_SESSION['prenom'] = $_POST['surname'];
                $validmail = validForm($_POST['mail'], "mail");//voir la fonction validForm dans le fichier fonctions/formulaire.php
                echo '<span class="mt-3 alert alert-success" role="alert">Le changement de vos informations personnelles est réussi </span>';
                if ($validmail) {
                    $stmt = $dbh->prepare('SELECT `mail_utilisateur` FROM `utilisateur` WHERE id_utilisateur_utilisateur =:id');
                    if ($stmt->execute(['id' => $_SESSION['id']])) {
                        $vMail = $stmt->fetchAll($fetchMode = PDO::FETCH_NAMED);
                        if ($_POST['mail'] !== $vMail[0]['mail_utilisateur']) {// si le mail dasns le champs est différent de celui en bdd
                            $vMail = $dbh->query('SELECT `mail_utilisateur` FROM `utilisateur`', $fetchMode = PDO::FETCH_NAMED)->fetchall();
                            if (isUnique($vMail, $_POST['mail'], 'mail_utilisateur')) {//si le mail n'existe pas en bdd
                                $stmt = $dbh->prepare('update utilisateur set mail_utilisateur=:mail WHERE `id_utilisateur_utilisateur`=:id');
                                if ($stmt->execute(['mail' => $_POST['mail'], 'id' => $_SESSION['id']])) {
                                    $_SESSION['mail'] =  $_POST['mail'];
                                    echo '<span class="mt-3 alert alert-success" role="alert">Le changement d\'adresse mail est réussi </span>';
                                }
                            } else {
                                include_once(__DIR__ . '/../../pages/profil.php');
                                echo '<span class="mt-3 alert alert-danger" role="alert">le mail est déjà en base de données</span>';
                            }
                        }
                    }
                }
            } else {
                echo '<span class="mt-3 alert alert-danger" role="alert"> Erreur lors de la soumission du formulaire</span>';
            }

            //mise à jour du mdp
            $egalMdp = egalvalue($_POST['pass'], $_POST['realpass']);//voir la fonction egalvalue dans le fichier fonctions/formulaire.php
            if (!empty($_POST['pass'])) { //si le champs est rempli
                if ($egalMdp) {// si les valeurs correspondent
                    $regex = "/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$/";
                    if (preg_match($regex, $_POST['pass'])) {
                        $mdp = password_hash($_POST['pass'], PASSWORD_DEFAULT);//on verifie que le mot de passe correspondt à notre patern
                        $stmt = $dbh->prepare('update utilisateur set password_utilisateur=:pwd WHERE `id_utilisateur_utilisateur`=:id');
                        if ($stmt->execute(['pwd' => $mdp, 'id' => $_SESSION['id']])) {
                            echo '<span class="mt-3 alert alert-success" role="alert">Le changement de mot de passe est réussi </span>';
                        } else {
                            echo '<span class="mt-3 alert alert-danger" role="alert"> Erreur lors de la soumission du formulaire</span>';
                        }
                    } else {
                        echo '<span class="mt-3 alert alert-danger" role="alert">Votre mot de passe ne contient pas les caractères attendus (1 Maj, 1 Min, 1 Chiffre, 1 carac spécial)</span>';
                    }
                } else {
                    echo '<span class="mt-3 alert alert-danger" role="alert">Vos mots de passes ne correspondent pas</span>';
                }
            }
            
            //mise à jour de la photo
            if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {//si on nous envoie une photo
                if (validFile('file', ['jpeg','png','jpg', 'webp'], '/../../upload/photos/', 'photo')) { //voir la fonction egalvalue dans le fichier fonctions/formulaire.php
                    $photo = htmlentities($_POST['photo']);
                    $stmt = $dbh->prepare("update utilisateur set `photo_utilisateur`=:photo WHERE `id_utilisateur_utilisateur`=:id");
                    if ($stmt->execute(['photo' => $photo, 'id' => $_SESSION['id']])) {
                        if($_SESSION['photo'] !== null){//si une photo est déjà existante
                            unlink(__DIR__.'/../../upload/photos/'.$_SESSION['photo']);
                        }
                        $_SESSION['photo'] = $_POST['photo'];
                        echo '<span class="mt-3 alert alert-success" role="alert">Le changement de votre photo est chargé</span>';
                    } else {
                        echo '<span class="mt-3 alert alert-danger" role="alert"> Erreur lors de la soumission du formulaire</span>';
                    }
                }
            }
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }
}
