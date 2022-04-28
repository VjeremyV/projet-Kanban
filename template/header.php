<header>
    <h1>
        Tretrello - Kanban
    </h1>
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
                    if ($is_connected === true) : //* A voir pour valider la connexion
                ?>
                <li class="navbar-item">
                    <a href="index.php?page=projetCours" class="nav-link">Projet en cours</a>
                 </li>
                 <li class="navbar-item">
                    <a href="index.php?page=projetFinis" class="nav-link">Projet Finis</a>
                 </li>
                 <li class="navbar-item">
                    <a href="index.php?page=creerProjet" class="nav-link">Créer Projet</a>
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