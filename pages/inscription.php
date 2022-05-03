<?php
echo '
    <form action="?inscription=true" method="POST" class="flex-md-columns col-md-6" enctype="multipart/form-data">

        <div class="form-floating my-3">
            <input type="text" name="name" id="name" class="form-control" placeholder="Nom">
            <label for="name">Nom</label>
        </div>
 
        <div class="form-floating my-3">
            <input type="text" name="surname" id="surname"  class="form-control" placeholder="Prenom">
            <label for="surname" class="form-label pe-2">Prénom</label>
        </div>

        <div class="form-floating my-3">
            <input type="mail" name="mail" id="mail"  class="form-control" placeholder="mail">
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


        <div class="d-flex justify-content-center justify-content-md-between align-items-center mt-3">
            <div class="g-recaptcha mt-3 my-mt-0" data-sitekey="6LeW3LMfAAAAAMugN2owWR3iIAJVqOfjfebFecZc"></div>
            <input type="submit" value="s\'incrire" name="submit" class="btn btn-primary h-25">
            </div>
    </form>

    <span class="border-end border-success border-5 rounded mx-md-5 d-none d-md-flex"></span>

   
    ';
