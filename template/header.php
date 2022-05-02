<?php include_once(__DIR__ . '/../src/fonctions/security.php');
include_once(__DIR__ . '/../src/fonctions/affichage.php');
?>

<body>
    <header class="container" role="banner">






        <nav class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-around">
            <div class="d-flex justify-content-around align-items-center bg-light px-lg-3">
                <a href="./../index.php" class="text-decoration-none flex-column">
                    <img src="./../style/assets/tretrello_logo.webp" class="image" alt="logo-tretrello">
                    <p class="text-primary fw-bold fs-3 ms-1 slogan">C'est très très bien</p>
                </a>
                <?php
                // Si connecter alors afficher les projets, le profil et le déconnexion
                if (isConnect()) : //* A voir pour valider la connexion
                ?>
                    <div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
            </div>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link border-bottom border-info <?= isset($_GET['page']) && $_GET['page'] == "encours" ? "warning" : "primary" ?>" <?= isset($_GET['page']) && $_GET['page'] == "encours" ?: "" ?>href="/../pages/projets.php?page=encours">Projet en cours</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link border-bottom border-info <?= isset($_GET['page']) && $_GET['page'] == "terminer_projet" ? "warning" : "primary" ?>" <?= isset($_GET['page']) && $_GET['page'] == "encours" ?: "" ?>href="/../pages/projets.php?page=terminer_projet">Projet Finis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link border-bottom border-info <?= isset($_GET['page']) && $_GET['page'] == "creerprojet" ? "warning" : "primary" ?>" <?= isset($_GET['page']) && $_GET['page'] == "encours" ?: "" ?>href="/../pages/createprojet.php?creation=0&page=creerprojet"> Créer Projet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link border-bottom border-info <?= isset($_GET['page']) && $_GET['page'] == "profil" ? "warning" : "primary" ?>" <?= isset($_GET['page']) && $_GET['page'] == "encours" ?: "" ?> href="index.php?page=profil">Profil</a>
                    </li>
                    <li>
                        <a class="nav-link border-bottom border-info" href="./../pages/deconnexion.php">Se déconnecter</a>
                    </li>
                </ul>
            </div>
        </nav>

    <?php
                endif;
    ?>
    <h1>
        <!-- je change le titre en fonction de la page sur laquelle je suis -->
        <?php
        setContent('Accueil - Tretrello', 'Inscription à Tretrello', 'Gestion du profil', 'Vos Projet en cours', 'Créer un nouveau projet', 'Vos Projets terminés');
        ?>
    </h1>
    </header>
    <main class="container">