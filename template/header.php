<?php include_once(__DIR__.'/../src/fonctions/security.php');
include_once(__DIR__.'/../src/fonctions/affichage.php');
?>

<body>
<header class="container-fluid" role="banner">

<div class="col d-flex justify-content-between align-items-center bg-light  px-lg-3">

<a href="./../index.php" class=" col-lg-4 d-flex align-items-start text-decoration-none flex-column">
    <img src="./../style/assets/tretrello_logo.webp" class="image" alt="logo-tretrello">
    <p class="text-primary fw-bold fs-3 ms-1 slogan">C'est très très bien</p>
</a>
<?php
// Si connecter alors afficher les projets, le profil et le déconnexion
                    if (isConnect()) : //* A voir pour valider la connexion
                ?>
<nav class=" col-lg-8 d-none d-lg-block">
    <ul class="d-flex text-black-50 fw-bold justify-content-between fs-5 mt-3 align-items-center">
        <li><a class='link-<?= isset($_GET['page']) && $_GET['page']== "encours" ? "warning" : "primary"?>' <?= isset($_GET['page']) && $_GET['page']== "encours" ? "title='Lien actif'" : ""?>href="../pages/projets.php?page=encours" >Projet en cours</a></li>
        <li><a class="link-<?= isset($_GET['page']) && $_GET['page']== "terminer_projet" ? "warning" : "primary"?>" <?= isset($_GET['page']) && $_GET['page']== "encours" ? "title='Lien actif'" : ""?>href="../pages/projets.php?page=terminer_projet" >Projet Finis</a></li>
        <li><a class="link-<?= isset($_GET['page']) && $_GET['page']== "creerprojet" ? "warning" : "primary"?>" <?= isset($_GET['page']) && $_GET['page']== "encours" ? "title='Lien actif'" : ""?>href="../pages/createprojet.php?creation=0&page=creerprojet"> Créer Projet</a></li>
        <li><a class="link-<?= isset($_GET['page']) && $_GET['page']== "profil" ? "warning" : "primary"?>"<?= isset($_GET['page']) && $_GET['page']== "encours" ? "title='Lien actif'" : ""?> href="../pages/profil.php?page=profil" ><img class ="userImage" src=" <?= isset($_SESSION['photo']) && !empty($_SESSION['photo']) ? $_SESSION['photo'] : "/../style/assets/defaultUser.webp"  ?>" alt="">
</a></li>
        <li><a class="link-primary" href="./../pages/deconnexion.php">Se déconnecter</a></li>
    </ul>
</nav>

<a class="nav-link dropdown-toggle d-lg-none text-success" href="#" id="navbarDropdownMenuLink"
    role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        class="bi bi-list text-success" viewBox="0 0 16 16">
        <path fill-rule="evenodd"
            d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
    </svg>
</a>

<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
    <li><a class="dropdown-item" href="../pages/projets.php?page=encours" >Projet en cours</a></li>
    <li><a class="dropdown-item" href="../pages/projets.php?page=terminer_projet" >Projet Finis</a></li>
    <li><a class="dropdown-item" href="../pages/createprojet.php?creation=0&page=creerprojet"> Créer Projet</a></li>
    <li><a class="dropdown-item" href="index.php?page=profil" ><img class ="userImage" src=" <?= isset($_SESSION['photo']) && !empty($_SESSION['photo']) ? $_SESSION['photo'] : "/../style/assets/defaultUser.webp"  ?>" alt="">
</a></li>
    <li><a class="dropdown-item" href="./../pages/deconnexion.php">Se déconnecter</a></li>
</ul>
<?php
                    endif;
                 ?>
</div>
    <h1>
 <!-- je change le titre en fonction de la page sur laquelle je suis -->
         <?php
       setContent('Accueil - Tretrello', 'Inscription à Tretrello', 'Gestion du profil', 'Vos Projet en cours','Créer un nouveau projet', 'Vos Projets terminés');
         ?> 
    </h1>
</header>
<main class="container">