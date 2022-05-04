<?php include_once(__DIR__.'/../src/fonctions/affichage.php');//fichier qui contient la fonction setContent?>
<!DOCTYPE html>
<html lang="fr">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name='description' content="<?php setContent('Bienvenue sur TRETRELLO, le n°1 en matière de gestion de projet et Kanbans !',
        'L\'inscription à TRETRELLO, c\'est par ici !', 'Modifiez vos informations personnelles sur cette page', 'Visualisez vos projets en cours', 'Créez de nouveaux projets', 'Visualisez vos projets terminés')?>">

        <title><?php setContent('Accueil - TRETRELLO', 'Inscription - TRETRELLO', 'Votre Profil - TRETRELLO', 'Vos Projets en cours - TRETRELLO', 'Création d\'un nouveau projet - TRETRELLO', 'Vos Projets terminés - TRETRELLO')?></title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="./../style/charte.css">

        <?php if (isset($_GET['kanban']) && $_GET['kanban'] == "true"): ?>
        <link rel="stylesheet" href="./../style/projet.css">
        <link rel="stylesheet" href="./../style/modal.css">
        
        <?php elseif ((isset($_GET['kanban']) && $_GET['kanban'] == "false") || (isset($_GET['page']) && $_GET['page']== "encours")): ?>
                <link rel="stylesheet" href="./../style/modal.css">
        <?php endif ?>
</head>