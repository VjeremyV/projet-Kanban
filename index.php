<?php
include_once("./template/head.php");
include_once("./template/header.php");
include_once('./pages/connexion.php');//gère la connexion
include_once('./src/fonctions/formulaire.php');//contient les fonctions formulaires
include_once('./src/fonctions/security.php');//contient les fonctions de securité

if(isConnect()){//vérifie si la connexion est établie sinon renvoie à l'accueil
    ?><p>Bonjour <?= $_SESSION['prenom']." ".$_SESSION['nom']?></p><?php
} else {
    ?>
    
    <form action="" method="POST" class="d-flex flex-column flex-md-row justify-content-end align-items-center mb-3">
        <div class="form-floating mx-2 h-25">
            <input class="form-control m-1" type="text" id="email" name="email" placeholder="email" />
            <label class="form-label m-1" for="email">Votre email</label>
        </div>

        <div class="form-floating mx-2">
            <input class="form-control m-1" id="mdp" type="password" name="mdp" placeholder="pass" />
            <label class="form-label m-1" for="mdp">Votre mot de passe</label>
        </div>

        <input class="m-1 btn btn-primary" type="submit" value="Se connecter" name="submit">
    </form>

    <?php include_once('./src/core/routeur.php');?>
    <div class="d-md-flex mt-4 mb-5 justify-content-center align-items-center">

    <?php
    if (isset($_GET['inscription']) && $_GET['inscription'] === "true") {
        $validName = validForm($_POST['name']);//voir fonction validForm dans fonctions/formulaire.php
        $validSurname = validForm($_POST['surname']);//voir fonction validForm dans fonctions/formulaire.php
        $validmail = validForm($_POST['mail'], "mail");//voir fonction validForm dans fonctions/formulaire.php
        $validMdp = validForm($_POST['pass']);//voir fonction validForm dans fonctions/formulaire.php
        $egalMdp = egalvalue($_POST['pass'], $_POST['realpass']);//voir fonction egalvalue dans fonctions/formulaire.php
        $secretKey = '6LeW3LMfAAAAAA7ZpTzAdmjOe_5gOn7ToSLcdQOn';
        $responseKey = $_POST['g-recaptcha-response'];//traitement recaptcha
        $userIP = $_SERVER['REMOTE_ADDR'];//traitement recaptcha
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";//traitement recaptcha
        $response = file_get_contents($url);//traitement recaptcha
        $response = json_decode($response);//traitement recaptcha
        if ($response->success) {//si recaptcha ok
            if ($validName && $validmail && $validMdp && $validSurname && $validMdp) {//si champs valides
                if($egalMdp){//si mdp egaux
                $regex = "/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$/";
                if(preg_match($regex, $_POST['pass'])){//si mdp correspondant à la regex
                    try {
                        $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
                        $vMail = $dbh->query('SELECT `mail_utilisateur` FROM `utilisateur`', $fetchMode = PDO::FETCH_NAMED)->fetchall();
                        if (isUnique($vMail, $_POST['mail'], 'mail_utilisateur')) {//si le mail est unique en bdd (voir fonction isunique dans formulaire.php)
                            $name = htmlentities(ucfirst(strtolower(trim($_POST['name']))));
                            $surname = htmlentities(ucfirst(strtolower(trim($_POST['surname']))));
                            $mail = $_POST['mail'];
                            $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                            if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){//si on a un fichier
                                if(validFile('file', ['jpeg','png','jpg', 'webp'], '/../../upload/photos/', 'photo')){// on verifie sa validité (voir fonction validfile dans formulaire.php)
                                    $photo = htmlentities($_POST['photo']);
                                    $stmt = $dbh->prepare("insert into utilisateur (`nom_utilisateur`,`prenom_utilisateur`, `password_utilisateur`,`mail_utilisateur`, `photo_utilisateur`) VALUES (:nom, :prenom, :mdp, :mail, :photo);");
                                    if ($stmt->execute(['nom' => $name, 'prenom' => $surname, 'mdp' => $password, 'mail' => $mail , 'photo' => $photo])) {
                                    echo '<span class="m-3 alert alert-success" role="alert">Votre inscription s\'est bien passée, votre photo est chargée </span>';
                                    } else {
                                        echo '<span class="mt-3 alert alert-danger messageErreurs" role="alert"> Erreur lors de la soumission du formulaire</span>';
                                    }
                                } else {
                                    $stmt = $dbh->prepare("insert into utilisateur (`nom_utilisateur`,`prenom_utilisateur`, `password_utilisateur`,`mail_utilisateur`) VALUES (:nom, :prenom, :mdp, :mail);");
                                    if ($stmt->execute(['nom' => $name, 'prenom' => $surname, 'mdp' => $password, 'mail' => $mail])) {
                                        echo '<span class=" m-3 alert alert-success" role="alert">Votre inscription s\'est bien passée, Mais </span> <br>';
                                        echo '<span class="m-3 alert alert-dark" role="alert">Votre photo de profil ne correspond pas aux critères exigés</span>';
                                        } else {
                                            echo '<span class="mt-3 alert alert-danger messageErreurs" role="alert"> Erreur lors de la soumission du formulaire</span>';
                                        }
                                    
                                }
                            } else {
                                $stmt = $dbh->prepare("insert into utilisateur (`nom_utilisateur`,`prenom_utilisateur`, `password_utilisateur`,`mail_utilisateur`) VALUES (:nom, :prenom, :mdp, :mail);");
                                if ($stmt->execute(['nom' => $name, 'prenom' => $surname, 'mdp' => $password, 'mail' => $mail])) {
                                    echo '<span class=" m-3 alert alert-success" role="alert">Votre inscription s\'est bien passée</span> <br>';
                                    } else {
                                        echo '<span class="mt-3 alert alert-danger messageErreurs" role="alert"> Erreur lors de la soumission du formulaire</span>';
                                    }
                            }
                        } else {
                            include_once('./pages/inscription.php');
                            echo '<span class="mt-3 alert alert-danger messageErreurs" role="alert">le mail est déjà en base de données</span>';
                        }
                    } catch (Exception $e) {
                        echo 'Erreur : ' . $e->getMessage();
                    }
                } else {
                    include_once('./pages/inscription.php');
                    echo '<span class="mt-3 alert alert-danger messageErreurs" role="alert">Votre mot de passe ne contient pas les caractères attendus (1 Maj, 1 Min, 1 Chiffre, 1 carac spécial)</span>';
                }
                $dbh = null;
            } else {
                include_once('./pages/inscription.php');
                echo '<span class="mt-3 alert alert-danger messageErreurs" role="alert">Vos mots de passes ne correspondent pas</span>';
            } 
            } else {
                echo '<span class="mt-3 alert alert-danger messageErreurs" role="alert">veuillez renseigner correctement tous les champs</span>';
            }
        } else {
            include_once('./pages/inscription.php');
            echo '<span class="mt-5 alert alert-danger messageErreurs" role="alert">veuillez cocher le Recaptcha</span>';
        }
    } else {
        include_once('./pages/inscription.php');
    }

}
?>
 <div class="d-flex col-md-6 mt-4 mt-md-0"> 
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000">
                    <img src="https://picsum.photos/id/0/5616/3744" class="d-block w-100" alt="image de présentation tretrello">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="https://picsum.photos/id/1/5616/3744" class="d-block w-100" alt="image de présentation tretrello">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="https://picsum.photos/id/1008/5616/3744" class="d-block w-100" alt="image de présentation tretrello">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>
<?php
include_once('./template/footer.php');
?>