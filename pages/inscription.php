<?php
<<<<<<< HEAD
echo '
<div class="d-md-flex mt-4 col-md-11">
 <form action="?inscription=true" method="POST" class="flex-md-columns col-md-6">
=======
 echo '<form action="?inscription=true" method="POST" class =" d-flex flex-column justify-content-center align-items-center">
    
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
>>>>>>> developp

<div class="form-floating my-3">
 <input type="text" name="name" id="name" class="form-control" placeholder="Nom">
 <label for="name">Nom</label>
</div>
 
<<<<<<< HEAD
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
     <input type="file" name="file" id="file" class="form-control-sm" multiple>
</div>

     <div class="g-recaptcha mt-5 my-mt-0" data-sitekey="6LeW3LMfAAAAAMugN2owWR3iIAJVqOfjfebFecZc"></div>
 
<div class="d-flex justify-content-center justify-content-md-end mt-3">
 <input type="submit" value="s\'incrire" name="submit" class="btn btn-primary">
</div>
 </form>

 <span class="border-end border-success border-5 rounded mx-md-5 d-none d-md-flex"></span>

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
    ';
=======
 <input type="submit" value="s\'incrire" name="submit">
 </form> <span id="barre"></span>';
>>>>>>> developp
