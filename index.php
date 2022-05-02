<?php
include_once("./template/head.php");
include_once("./template/header.php");
include_once('./pages/connexion.php');
include_once('./src/fonctions/formulaire.php');
include_once('./src/fonctions/security.php');
if(isConnect()){
    ?><p>Bonjour <?= $_SESSION['prenom']." ".$_SESSION['nom']?></p><?php
} else {
    ?>
    
    <form action="" method="POST">
        <label for="mail">Votre email</label>
        <input type="text" name="mail" />
    
        <label for="mdp">Votre mot de passe</label>
        <input type="password" name="mdp" />
        
        <input type="submit" value="Se connecter" name="submit">
    </form>
    
    <?php
    include_once('./src/core/routeur.php');
    if (isset($_GET['inscription']) && $_GET['inscription'] === "true") {
        $validName = validForm($_POST['name']);
        $validSurname = validForm($_POST['surname']);
        $validmail = validForm($_POST['mail'], "mail");
        $validMdp = validForm($_POST['pass']);
        $egalMdp = egalvalue($_POST['pass'], $_POST['realpass']);
        $secretKey = '6LeW3LMfAAAAAA7ZpTzAdmjOe_5gOn7ToSLcdQOn';
        $responseKey = $_POST['g-recaptcha-response'];
        $userIP = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
        $response = file_get_contents($url);
        $response = json_decode($response);
        if ($response->success) {
            if ($validName && $validmail && $validMdp && $validSurname && $validMdp) {
                try {
                    $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
                    $vMail = $dbh->query('SELECT `mail_utilisateur` FROM `utilisateur`', $fetchMode = PDO::FETCH_NAMED)->fetchall();
                    if (isUnique($vMail, $_POST['mail'], 'mail_utilisateur')) {
                        $name = htmlentities(ucfirst(strtolower(trim($_POST['name']))));
                        $surname = htmlentities(ucfirst(strtolower(trim($_POST['surname']))));
                        $mail = $_POST['mail'];
                        $password = crypt($_POST['pass'], CRYPT_SHA512);
                        // $stmt = $dbh->prepare("insert into utilisateur (`nom_utilisateur`,`prenom_utilisateur`, `password_utilisateur`,`mail_utilisateur`) VALUES (:nom, :prenom, :mdp, :mail);");
                        if(isset($_FILES)){
                            if(validFile('file')){
                                $photo = htmlentities($_POST['photo']);
                                $stmt = $dbh->prepare("insert into utilisateur (`nom_utilisateur`,`prenom_utilisateur`, `password_utilisateur`,`mail_utilisateur`, `photo_utilisateur`) VALUES (:nom, :prenom, :mdp, :mail, :photo);");
                                if ($stmt->execute(['nom' => $name, 'prenom' => $surname, 'mdp' => $password, 'mail' => $mail , 'photo' => $photo])) {
                                echo "<span>Votre inscription s'est bien passée, votre photo est chargée </span>";
                                } else {
                                    echo '<span class="error"> Erreur lors de la soumission du formulaire</span>';
                                }
                            } else {
                                $stmt = $dbh->prepare("insert into utilisateur (`nom_utilisateur`,`prenom_utilisateur`, `password_utilisateur`,`mail_utilisateur`) VALUES (:nom, :prenom, :mdp, :mail);");
                                if ($stmt->execute(['nom' => $name, 'prenom' => $surname, 'mdp' => $password, 'mail' => $mail])) {
                                    echo "<span>Votre inscription s'est bien passée, Mais </span> <br>";
                                    echo "<span>Votre photo de profil ne correspond pas aux critères exigés</span>";
                                    } else {
                                        echo '<span class="error"> Erreur lors de la soumission du formulaire</span>';
                                    }
                                
                            }
                        } else {
                            $stmt = $dbh->prepare("insert into utilisateur (`nom_utilisateur`,`prenom_utilisateur`, `password_utilisateur`,`mail_utilisateur`) VALUES (:nom, :prenom, :mdp, :mail);");
                            if ($stmt->execute(['nom' => $name, 'prenom' => $surname, 'mdp' => $password, 'mail' => $mail])) {
                                echo "<span>Votre inscription s'est bien passée, Mais </span> <br>";
                                } else {
                                    echo '<span class="error"> Erreur lors de la soumission du formulaire</span>';
                                }
                        }
                    } else {
                        include_once('./pages/inscription.php');
                        echo "<span>le mail est déjà en base de données</span>";
                    }
                } catch (Exception $e) {
                    echo 'Erreur : ' . $e->getMessage();
                }
                $dbh = null;
            } else {
                include_once('./pages/inscription.php');
                echo "<span>veuillez remplir tous les champs</span>";
            } 
        } else {
            include_once('./pages/inscription.php');
            echo "<span>veuillez cocher le Recaptcha</span>";
        }
    } else {
        include_once('./pages/inscription.php');
    }

}

include_once('./template/footer.php');
?>