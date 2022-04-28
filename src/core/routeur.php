<?php
$page = "accueil.php";

if(isset($_GET['page'])){
    $page = $_GET['page'];
    if(file_exists(__DIR__.'/../../pages/'.$page)){
        include_once(__DIR__.'/../../pages/'.$page);
    } else {
        include_once(__DIR__.'/../../pages/erreur.php');
    }
} else {
    include_once(__DIR__.'/../../pages/'.$page);
}
