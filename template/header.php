<body>
   
<header>
    <h1>
        //* je change le titre en fonction de la page sur laquelle je suis
         <?php
            if(isset($_GET['page'])){
                $page = $_GET['page'];
                switch($page){
                    case 'accueil':
                        echo 'Accueil - Tretrello';
                        break;
                    case 'inscription':
                        echo 'Inscription à Tretrello';
                        break;
                    case 'profil':
                        echo 'Gestion du profil de '.$_SESSION['nom'].' '.$_SESSION['prenom'];
                        break;
                    case 'projetcours':
                        echo 'Projet Tretrello en cours';
                        break;
                     case 'projetfinis':
                        echo 'Projet Tretrello Finis';
                        break;
                    case 'creerprojet':
                        echo 'Créer un nouveau projet';
                        break;
                   
                    default:
                        echo 'Accueil';
                        break;
                }
            }
            else{
                echo 'Accueil';
            }
         ?> 
    </h1>
    <h2>C'est très très bien</h2>
    //* logo du site
    <img src="./../style/assets/tretrello_logo.webp" alt="logo tretrello">
    <nav>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="navbar-item">
                    <a href="index.php" class="nav-link">Tretrello</a>
                </li>
                <?php
                //* Si connecter alors afficher les projets, le profil et le déconnexion
                    if ($is_connected === true) : //* A voir pour valider la connexion
                ?>
                <li class="navbar-item">
                    <a href="index.php?page=projetcours" class="nav-link">Projet en cours</a>
                 </li>
                 <li class="navbar-item">
                    <a href="index.php?page=projetfinis" class="nav-link">Projet Finis</a>
                 </li>
                 <li class="navbar-item">
                    <a href="index.php?page=creerprojet" class="nav-link">Créer Projet</a>
                 </li>
                 <li class="navbar-item">
                    <a href="index.php?page=profil" class="nav-link">Profil</a>
                 </li>
                 <?php
                    endif;
                 ?>
                 <?php
                    if ($is_connected === false) :
                 ?>
                 <li class="navbar-item">
                    <a href="index.php?page=connexion" class="nav-link">Se connecter</a>
                 </li>
                 <?php
                    else :
                 ?>
                 <li class="navbar-item">
                    <a href="index.php?page=deconnexion" class="nav-link">Se déconnecter</a>
                 </li>
                 <?php
                    endif;
                 ?>
            </ul>
        </div>
    </nav>
</header>
<main>