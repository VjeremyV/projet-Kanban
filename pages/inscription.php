<?php
 echo '<form action="?inscription=true" method="POST">
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

     <div class="g-recaptcha" data-sitekey="6LeW3LMfAAAAAMugN2owWR3iIAJVqOfjfebFecZc"></div>
 
 <input type="submit" value="s\'incrire" name="submit">
 </form>';