
 echo '<form  class = "form-group d-flex flex-column justify-content center  align-items center" action="?inscription=true" method="POST">
 <div class="form-group">
 <label for="name">Nom :</label>
     <input type="text" class = "form-control" name="name" id="name" >
 
     <label for="surname">Prénom :</label>
     <input type="text" name="surname" id="surname" >
 
     <label for="mail">Adresse mail :</label>
     <input type="mail"  class="form-control" name="mail" id="mail" >
 
     <label for="pass">Mot de passe :</label>
     <input type="password"  class="form-control" name="pass" id="pass" >
 
     <label for="realpass">Confirmez votre mot de passe :</label>
     <input type="password" class="form-control" name="realpass" id="realpass" >
 
     <label for="file">Ajoutez une photo de profil :</label>
     <input type="file" class="form-control" name="file" id="file">

     <div class="g-recaptcha" data-sitekey="6LeW3LMfAAAAAMugN2owWR3iIAJVqOfjfebFecZc"></div>
 
 <input type="submit" value="s\'incrire" name="submit">
 <div class="form-group">
<span id = "barre"></span></form>';
