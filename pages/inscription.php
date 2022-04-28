<?php
include_once(__DIR__.'/../src/fonctions/fonctions.php');

if (isset($_GET['inscription']) && $_GET['inscription'] === "true") {
    $validName = Validform($_POST['name']);
    $validSurname = Validform($_POST['surname']);
    $validmail = Validform($_POST['mail'], "mail");
    $validMdp = egalvalue($_POST['pass'], $_POST['realpass']);

if($validName && $validmail && $validMdp && $validSurname){

    $name = htmlentities(ucfirst(strtolower(trim($_POST['name']))));
    $surname = htmlentities(ucfirst(strtolower(trim($_POST['surname']))));
    $mail = $_POST['mail'];
    $password = crypt($_POST['pass'], CRYPT_SHA512);

    try{
        $dbh = new PDO('mysql:host=localhost;dbname=tretrello', 'tretrello', 'tretrello', array(PDO::ATTR_PERSISTENT => true));
        $stmt = $dbh->prepare("insert into utilisateur (`nom_utilisateur`,`prenom_utilisateur`, `password_utilisateur`,`mail_utilisateur`) VALUES (:nom, :prenom, :mdp, :mail);");
        if(!$stmt->execute(['nom' => $name, 'prenom' => $surname, 'mdp' => $password, 'mail' => $mail])){
            print '<h2 class="error">Erreur de récupération des données : ' . print_r($statement->errorInfo()) . '</h2>';
        } else {
            echo "on est bon";
        }
    }  catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}

} else {
    echo '<form action="./inscription.php?inscription=true" method="POST">
    <label for="name">Nom :</label>
        <input type="text" name="name" id="name" >
    
        <label for="surname">Prénom :</label>
        <input type="text" name="surname" id="surname" >
    
        <label for="mail">Adresse mail :</label>
        <input type="mail" name="mail" id="mail" >
    
        <label for="pass">Mot de passe :</label>
        <input type="password" name="pass" id="pass" >
    
        <label for="realpass">Confirmez votre mot de passe :</label>
        <input type="password" name="realpass" id="realpass" >
    
        <label for="file">Ajoutez une photo de profil :</label>
        <input type="file" name="file" id="file">
    
    <input type="submit" value="s\'incrire" name="submit">
    </form>';
}
