<?php

$dbh = new PDO('mysql:host=localhost;dbname=tretrelo', 'tretrelo', 'tretrelo', array(PDO::ATTR_PERSISTENT => true));

function createUser()
{
  $errors = [];
  if (isset($_POST['submit']) && $_POST['submit'] === "createUser") {
    if (isset($_POST['mail']) && $_POST['mail'] !== '') {
      if (isset($_POST['pass']) && $_POST['pass'] !== '') {
        if (isset($_POST['realpass']) && $_POST['pass'] === $_POST['realpass']) {
          $mail = search_user_by_mail($_POST['mail']);
          if ($mail === true) {
            $errors[] = print '<h3 style="color: red;">le mail est déjà utilisé pour un compte</h3>';
          } else {
            if (save_user($_POST['mail'], $_POST['pass'])) {
              print "<h3>L'utilisateur est bien enregistré</h3>";
            } else {
              $errors[] = print '<h3 style="color: red;">Un problème est survenu lors de votre insciption</h3>';
            }
          }
        } else {
          $errors[] = print '<h3 style="color: red;">Les mots de passes ne correspondent pas</h3>';
        }
      } else {
        $errors[] = print '<h3 style="color: red;">Le mot de passe est obligatoire</h3>';
      }
    } else {
      $errors[] = '<h3 style="color: red;">Votre adresse mail est obligatoire pour l\'inscription';
    }
  }

  if (count($errors) > 0) {
    foreach ($errors as $error) {
      echo $error;
    }
  }
}

function search_user_by_mail()
{
}

function save_user()
{
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>inscription</title>
</head>

<body>

  <form action="" method="post">
    <label for="name">Nom : </label>
    <input type="text" name="name" id="name" required>

    <label for="surname">Prénom : </label>
    <input type="text" name="surname" id="surname" required>

    <label for="mail">Adresse mail : </label>
    <input type="text" name="mail" id="mail" required>

    <label for="pass">Mot de passe : </label>
    <input type="text" name="pass" id="pass" required>

    <label for="realpass">Confirmez votre mot de passe : </label>
    <input type="text" name="realpass" id="realpass" required>

    <label for="file">Ajoutez une photo de profil : </label>
    <input type="file" name="file" id="file">

    <input type="submit" value="">
  </form>
</body>

</html>