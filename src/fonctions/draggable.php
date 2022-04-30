<?php

if(isset($_POST['saveTacheInput']) && isset($_POST['idCatInput'])){
    if(is_numeric($_POST['saveTacheInput']) && is_numeric($_POST['idCatInput'])){
        $stmt = $dbh->prepare('SELECT count(*) FROM `categories` WHERE `id_categorie_categories` = :idCat AND id_projet_projet ='.$idProjet);
        if ($stmt->execute(['idCat' => $_POST['idCatInput']])) {
            if($stmt->fetch() > 0){
                $stmt = $dbh->prepare('SELECT count(*) FROM `taches` join projet ON taches.id_projet_projet = projet.id_projet_projet WHERE taches.id_taches_taches = :idTache');
                if($stmt->execute(['idTache' => $_POST['saveTacheInput']])){
                    if($stmt->fetch() > 0){
                       $stmt = $dbh->prepare('UPDATE `taches` SET `id_categorie_categories` = :idCat WHERE `taches`.`id_taches_taches` = :idTache');
                       if(!$stmt->execute(['idCat' => $_POST['idCatInput'], 'idTache' => $_POST['saveTacheInput']])){
                        echo "<p>Une erreur est survenue lors de la mise à jour de votre kanban</p>";
                       }
                    }
                }
            }                 
        } else {
            echo "<p>Une erreur est survenue lors de la mise à jour de votre kanban</p>";
        }
    }
}