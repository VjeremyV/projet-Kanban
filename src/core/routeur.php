<?php
$page = "accueil";

if(isset($_GET['page'])){
    $page = $_GET['page'];
    if(file_exists(__DIR__.'/../pages/'.$page.".php")){
        include_once(__DIR__.'/../pages/'.$page.".php");
    } else {
        include_once(__DIR__.'/../pages/erreur.php');
    }
} else {
    include_once(__DIR__.'/../../pages/'.$page.".php");
}

