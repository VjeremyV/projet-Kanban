<?php
include_once(__DIR__.'./formulaire.php');
if (isset($_POST['newTache']) && !empty($_POST['newTache'])) {
    $newTache = htmlentities($_POST['newTache']);
    $newDescription = $_POST['newDescription'];
    $stmt = $dbh->prepare("insert into taches (`nom_taches`,`date_taches`,`id_categorie_categories`,`id_utilisateur_utilisateur`,`id_projet_projet`, `description_taches`) values (:tache, :date, :idCat, :idUser , :idProjet, :description)");
    if (!$stmt->execute(['tache' => $newTache, 'date' => date('Y-m-d'), 'idCat' => $_POST['idCat'], 'idUser' => $_SESSION['id'], 'idProjet' => $_GET['id'], 'description' => $newDescription])) {
        echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
    }
}

if (isset($_POST['nomTache']) && isset($_POST['description']) && isset($_POST['date']) && isset($_POST['idTache'])) {
    $nomTache = htmlentities($_POST['nomTache']);
    $description = htmlentities($_POST['description']);
    if(validateDate($_POST['date'], 'Y-m-d')){
        $date = htmlentities($_POST['date']);
        $idTache = $_POST['idTache'];
        $stmt = $dbh->prepare('UPDATE taches set `nom_taches`= :nom, `date_taches`= :date, `description_taches` = :description WHERE `id_taches_taches` = :idTache');
        if (!$stmt->execute(['nom' => $nomTache, 'date' => $date, 'description' => $description, 'idTache' => $idTache])) {
            echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
        }
    }
    if(isset($_POST['com']) && !empty($_POST['com'])){
        $commentaire = htmlentities($_POST['com']);
        $stmt = $dbh->prepare('insert into commentaires (`date_commentaires`, `texte_commentaires`,`id_utilisateur_utilisateur`,`id_taches_taches`) values (:dateCom, :textCom, :idUser, :idTache )');
        if(!$stmt->execute(['dateCom' => date('Y-m-d'), 'textCom' => $commentaire, 'idUser' => $_SESSION['id'], 'idTache' => $idTache])){
            echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
        }
    }
}

if(isset($_POST['suppression']) && isset($_POST['supprId'])){
    $stmt=$dbh->prepare('DELETE FROM commentaires WHERE `id_taches_taches` = :idTache');
    if($stmt->execute(['idTache' => $_POST['supprId']])){
        $stmt = $dbh->prepare('DELETE FROM taches WHERE `id_taches_taches` = :idTache');
        if(!$stmt->execute(['idTache' => $_POST['supprId']])){
            echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
        }
    } else {
        echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
    }
}