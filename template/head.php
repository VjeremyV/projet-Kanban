<?php include_once(__DIR__.'/../src/fonctions/affichage.php');?>
<!DOCTYPE html>
<html lang="fr">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta description="<?php setContent('Bienvenue sur TRETRELLO, le n°1 en matière de gestion de projet et Kanbans !',
        'L\'inscription à TRETRELLO, c\'est par ici !', 'Modifiez vos informations personnelles sur cette page', 'Visualisez vos projets en cours', 'Créez de nouveaux projets', 'Visualisez vos projets terminés')?>">
        <title><?php setContent('Accueil - TRETRELLO', 'Inscription - TRETRELLO', 'Votre Profil - TRETRELLO', 'Vos Projets en cours - TRETRELLO', 'Création d\'un nouveau projet - TRETRELLO', 'Vos Projets terminés - TRETRELLO')?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="./../style/charte.css">
        <?php if (isset($_GET['kanban']) && $_GET['kanban'] == "true"): ?>
        <link rel="stylesheet" href="./../style/projet.css">
        <link rel="stylesheet" href="./../style/modal.css">
        <?php endif ?>
</head>