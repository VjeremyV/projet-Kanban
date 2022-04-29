<?php include_once(__DIR__.'/../src/fonctions/security.php');
include_once(__DIR__.'/../src/fonctions/affichage.php');
?>

<body>
<header>
    <h2>C'est très très bien</h2>
 <!-- logo du site -->
    <img src="./../style/assets/tretrello_logo.webp" alt="logo tretrello">
    <nav>
            <ul>

                <?php
// Si connecter alors afficher les projets, le profil et le déconnexion
                    if (isConnect()) : //* A voir pour valider la connexion
                ?>
                <li>
                    <a href="../pages/projets.php?page=encours" >Projet en cours</a>
                 </li>
                 <li >
                    <a href="../pages/projets.php?page=terminer_projet" >Projet Finis</a>
                 </li>
                 <li >
                    <a href="index.php?page=creerprojet"> Créer Projet</a>
                 </li>
                 <li >
                    <a href="index.php?page=profil" >Profil</a>
                 </li>
                 <li >
                    <a href="./../pages/deconnexion.php">Se déconnecter</a>
                 </li>
                 <?php
                    endif;
                 ?>
            </ul>
    </nav>
    <h1>
 <!-- je change le titre en fonction de la page sur laquelle je suis -->
         <?php
       setContent('Accueil - Tretrello', 'Inscription à Tretrello', 'Gestion du profil', 'Vos Projet en cours','Créer un nouveau projet', 'Vos Projets terminés');
         ?> 
    </h1>
</header>
<main>