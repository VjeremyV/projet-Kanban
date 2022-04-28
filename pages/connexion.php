<?php 
include_once(__DIR__.'/../src/fonctions/fonctions.php');
session_start();
if(isset($_SESSION['mail']))
{
    var_dump($_SESSION['mail']);
}
try {
    $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
    if(isset($_POST['mail']) && isset($_POST['mdp'])){
        if(validForm($_POST['mail'])){
            $mdp = crypt($_POST['mdp'], CRYPT_SHA512);
            $recupUser = $dbh->prepare('select * from utilisateur WHERE mail_utilisateur = :mail AND password_utilisateur =:password');
            $recupUser->execute(['mail' => $_POST['mail'], 'password' => $mdp]);
    
            if($recupUser->rowCount() > 0){
                echo "connecté";
                $_SESSION['mail']=$_POST['mail'];
            } else {
                echo "erreur vous êtes mauvais";
            }
        } else {
            echo "entrez un mail valide!!!";
        }
    }
}
catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>
<form action="" method="POST">
    <label for="mail">Votre email</label>
    <input type="text" name="mail"  />

    <label for="mdp">Votre mot de passe</label>
    <input type="password" name="mdp"  />

    <input type="submit" value="Se connecter" name="submit">
</form>
