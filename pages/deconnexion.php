<?php
include_once(__DIR__."/../src/fonctions/security.php"); // fichier qui gère la sécurité de la connexion
disconnect(); //voir fonctions/security.php
header('location: ./../index.php');