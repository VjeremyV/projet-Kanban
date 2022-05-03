<?php
session_start();
include_once(__DIR__ . '/../template/head.php');
include_once(__DIR__ . '/../src/fonctions/formulaire.php');
include_once(__DIR__ . '/../src/fonctions/security.php');
include_once(__DIR__ . '/../src/fonctions/modifier.php');
include_once(__DIR__ . '/../template/header.php');

if (isConnect()) {
    ?>
<form action="?modification=true" method="POST" class="flex-md-columns col-md-6" enctype="multipart/form-data">
    
    <div class="form-floating my-3">
        <input type="text" name="name" id="name" class="form-control" placeholder="Nom" value="<?= $_SESSION['nom']?>">
        <label for="name">Nom</label>
    </div>
    
    <div class="form-floating my-3">
        <input type="text" name="surname" id="surname"  class="form-control" placeholder="Prenom" value="<?= $_SESSION['prenom']?>">
        <label for="surname" class="form-label pe-2">Prénom</label>
    </div>
    
    <div class="form-floating my-3">
        <input type="mail" name="mail" id="mail"  class="form-control" placeholder="mail" value="<?= $_SESSION['mail']?>">
        <label for="mail" class="form-label pe-2">Adresse mail</label>
    </div>
    
    <div class="form-floating my-3">
        <input type="password" name="pass" id="pass"  class="form-control" placeholder="pass">
        <label for="pass" class="form-label pe-2">Mot de passe</label>
    </div> 
    
    <div class="form-floating my-3">
        <input type="password" name="realpass" id="realpass"  class="form-control" placeholder="realpass">
    <label for="realpass" class="form-label pe-2">Confirmez votre mot de passe</label>
</div> 

<div class="d-flex my-4 justify-content-between">
    <label for="file" class="form-label pe-2">Ajoutez une photo de profil :</label>
    <input type="file" name="file" id="file" class="form-control-sm">
</div>

<div class="d-flex justify-content-center justify-content-md-end align-items-center mt-3">
    <input type="submit" value="Modifier" name="submit" class="btn btn-primary h-25">
</div>
</form>



<?php
include_once(__DIR__ .'/../template/footer.php');
} else {
    header('location: ./../index.php');
}
?>