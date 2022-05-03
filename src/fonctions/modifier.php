<?php

if (isset($_POST['submit'])) {
    $validName = validForm($_POST['name']);
    $validSurname = validForm($_POST['surname']);
    if ($validName && $validSurname) {
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
            $stmt = $dbh->prepare('update utilisateur set `nom_utilisateur`=:nom ,`prenom_utilisateur`=:prenom WHERE `id_utilisateur_utilisateur`=:id');
            if ($stmt->execute(['nom' => $_POST['name'], 'prenom' => $_POST['surname'], 'id' => $_SESSION['id']])) {
                $_SESSION['nom'] = $_POST['name'];
                $_SESSION['prenom'] = $_POST['surname'];
                $validmail = validForm($_POST['mail'], "mail");
                echo '<span class="mt-3 alert alert-success" role="alert">Le changement de vos informations personnelles est réussi </span>';
                if ($validmail) {
                    $stmt = $dbh->prepare('SELECT `mail_utilisateur` FROM `utilisateur` WHERE id_utilisateur_utilisateur =:id');
                    if ($stmt->execute(['id' => $_SESSION['id']])) {
                        $vMail = $stmt->fetchAll($fetchMode = PDO::FETCH_NAMED);
                        if ($_POST['mail'] !== $vMail[0]['mail_utilisateur']) {
                            $vMail = $dbh->query('SELECT `mail_utilisateur` FROM `utilisateur`', $fetchMode = PDO::FETCH_NAMED)->fetchall();
                            if (isUnique($vMail, $_POST['mail'], 'mail_utilisateur')) {
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
            $egalMdp = egalvalue($_POST['pass'], $_POST['realpass']);
            if (!empty($_POST['pass'])) {
                if ($egalMdp) {
                    $regex = "/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$/";
                    if (preg_match($regex, $_POST['pass'])) {
                        $stmt = $dbh->prepare('update utilisateur set password_utilisateur=:pwd WHERE `id_utilisateur_utilisateur`=:id');
                        if ($stmt->execute(['pwd' => $_POST['pass'], 'id' => $_SESSION['id']])) {
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
            if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
                if (validFile('file')) {
                    $photo = htmlentities($_POST['photo']);
                    $stmt = $dbh->prepare("update utilisateur set `photo_utilisateur`=:photo WHERE `id_utilisateur_utilisateur`=:id");
                    if ($stmt->execute(['photo' => $photo, 'id' => $_SESSION['id']])) {
                        if($_SESSION['photo'] !== ""){
                            unlink(__DIR__.'/../../upload/'.$_SESSION['photo']);
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
    // $validMdp = validForm($_POST['pass']);
    // $egalMdp = egalvalue($_POST['pass'], $_POST['realpass']);
}
