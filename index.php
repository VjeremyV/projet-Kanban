<?php
include_once('./pages/connexion.php');
include_once("./template/head.php");
include_once("./template/header.php");
include_once('./src/core/routeur.php');
include_once('./src/fonctions/formulaire.php');

?>

<form action="" method="POST">
    <label for="mail">Votre email</label>
    <input type="text" name="mail" />

    <label for="mdp">Votre mot de passe</label>
    <input type="password" name="mdp" />

    <input type="submit" value="Se connecter" name="submit">
</form>

<?php
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
                    $stmt = $dbh->prepare("insert into utilisateur (`nom_utilisateur`,`prenom_utilisateur`, `password_utilisateur`,`mail_utilisateur`) VALUES (:nom, :prenom, :mdp, :mail);");
                    if (!$stmt->execute(['nom' => $name, 'prenom' => $surname, 'mdp' => $password, 'mail' => $mail])) {
                        print '<h2 class="error">Erreur de récupération des données : ' . print_r($statement->errorInfo()) . '</h2>';
                    } else {
                        echo "<p> Formulaire validé, Vous êtes desormais inscrit ! <!p>";
                    }
                } else {
                    echo "le mail est déjà en base de données<br>";
                }
            } catch (Exception $e) {
                echo 'Erreur : ' . $e->getMessage();
            }
            $dbh = null;
        } 
    } else {
        include_once('./pages/inscription.php');
        echo "veuillez cocher le Recaptcha";
    }
} else {
    include_once('./pages/inscription.php');
}

include_once('./template/footer.php');
?>