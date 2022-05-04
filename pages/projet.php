<?php
session_start();
include_once(__DIR__ . '/../template/head.php');
include_once(__DIR__ . '/../template/header.php');
include_once(__DIR__ . '/../src/fonctions/formulaire.php');

if (isConnect()) { //vérifie si la connexion est établie sinon renvoie à l'accueil
    if($_GET['kanban'] === 'true'): //on verifie la valeur de kanban dans la querystring pour afficher la bonne version de la page
        include_once(__DIR__.'/projet_encours.php');
    ?>
    <?php
    else :
        include_once(__DIR__.'/projet_termine.php');
        endif;

        
    include_once(__DIR__ . '/../template/footer.php');
} else {
    header('location: ./../index.php');
}
    ?>