<?php
echo '
<div class="d-md-flex mt-4">
 <form action="?inscription=true" method="POST" class="flex-md-columns col-md-6">

 <div class="d-flex my-2 justify-content-between me-0 justify-content-md-between">
    <label for="name" class="form-label pe-2">Nom :</label>
     <input type="text" name="name" id="name"  class="form-control-sm">
</div>
 
<div class="d-flex my-2 justify-content-between justify-content-md-between">
     <label for="surname" class="form-label pe-2">Prénom :</label>
     <input type="text" name="surname" id="surname"  class="form-control-sm">
</div>

<div class="d-flex my-2 justify-content-between justify-content-md-between">
     <label for="mail" class="form-label pe-2">Adresse mail :</label>
     <input type="mail" name="mail" id="mail"  class="form-control-sm">
</div>

<div class="d-flex my-2 justify-content-between justify-content-md-between">
     <label for="pass" class="form-label pe-2">Mot de passe :</label>
     <input type="password" name="pass" id="pass"  class="form-control-sm">
</div> 

<div class="d-flex my-2 justify-content-between justify-content-md-between">
     <label for="realpass" class="form-label pe-2">Confirmez votre mot de passe :</label>
     <input type="password" name="realpass" id="realpass"  class="form-control-sm">
</div> 

<div class="d-flex my-2 justify-content-between justify-content-md-between">
     <label for="file" class="form-label pe-2">Ajoutez une photo de profil :</label>
     <input type="file" name="file" id="file" class="form-control-sm" multiple>
</div>

     <div class="g-recaptcha" data-sitekey="6LeW3LMfAAAAAMugN2owWR3iIAJVqOfjfebFecZc"></div>
 
<div>
 <input type="submit" value="s\'incrire" name="submit" class="btn btn-primary">
</div>
 </form>

 <span class="border-end border-dark border-5 rounded mx-md-5"></span>

<div class="d-flex col-md-6 mt-4 mt-md-0"> 
 <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
 <div class="carousel-inner">
   <div class="carousel-item active" data-bs-interval="5000">
     <img src="https://picsum.photos/id/0/5616/3744" class="d-block w-100" alt="...">
   </div>
   <div class="carousel-item" data-bs-interval="5000">
     <img src="https://picsum.photos/id/1/5616/3744" class="d-block w-100" alt="...">
   </div>
   <div class="carousel-item" data-bs-interval="5000">
     <img src="https://picsum.photos/id/1008/5616/3744" class="d-block w-100" alt="...">
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
