<?php
include_once(__DIR__ . '/formulaire.php');
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
    $idTache = $_POST['idTache'];
    if (validateDate($_POST['date'], 'Y-m-d')) {
        $date = htmlentities($_POST['date']);
        $stmt = $dbh->prepare('UPDATE taches set `nom_taches`= :nom, `date_taches`= :date, `description_taches` = :description WHERE `id_taches_taches` = :idTache');
        if (!$stmt->execute(['nom' => $nomTache, 'date' => $date, 'description' => $description, 'idTache' => $idTache])) {
            echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
        }
    }
    if (isset($_POST['com']) && !empty($_POST['com'])) {
        $commentaire = htmlentities($_POST['com']);
        $stmt = $dbh->prepare('insert into commentaires (`date_commentaires`, `texte_commentaires`,`id_utilisateur_utilisateur`,`id_taches_taches`) values (:dateCom, :textCom, :idUser, :idTache )');
        if (!$stmt->execute(['dateCom' => date('Y-m-d'), 'textCom' => $commentaire, 'idUser' => $_SESSION['id'], 'idTache' => $idTache])) {
            echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
        }
    }
    if (isset($_FILES['fichier']) && !empty($_FILES['fichier']['name'])) {
        if (validFile('fichier', ['jpeg', 'png', 'jpg', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx'], '/../../upload/fichiers/')) {
            $fichier = htmlentities($_POST['fichier']);
            $stmt = $dbh->prepare("insert into fichiers (`nom_fichiers`, `date_fichiers`,`id_taches_taches`,`id_utilisateur_utilisateur`,`user_nom_fichier`) VALUES (:fichier, :date, :idTache, :idUser, :userNomFichier)");
            if (!$stmt->execute(['fichier' => $fichier, 'date' => date('Y-m-d'), 'idTache' => $idTache, 'idUser' => $_SESSION['id'], 'userNomFichier' => $_FILES['fichier']['name']])) {
                echo "<span>Une erreur lors du téléchargement est survenue</span>";
            } else {
                echo '<span>Erreur de connexion à la base de données</span>';
            }
        } else {
            echo "<span>Erreur de validation de fichier</span>";
        }
    }
}

if (isset($_POST['suppression']) && isset($_POST['supprId'])) {
    $stmt = $dbh->prepare('DELETE FROM commentaires WHERE `id_taches_taches` = :idTache');
    if ($stmt->execute(['idTache' => $_POST['supprId']])) {
        $stmt = $dbh->prepare('DELETE FROM fichiers WHERE `id_taches_taches` = :idTache');
        if($stmt->execute(['idTache' => $_POST['supprId']])){
            $stmt = $dbh->prepare('DELETE FROM taches WHERE `id_taches_taches` = :idTache');
            if (!$stmt->execute(['idTache' => $_POST['supprId']])) {
                echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
            }
        }
    } else {
        echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
    }
}

if (isset($_POST['newCategorie']) && !empty($_POST['newCategorie'])) {
    $newCat = htmlentities($_POST['newCategorie']);
    $stmt = $dbh->prepare('select Count(*) from categories Where `id_projet_projet` = :idProjet');
    if ($stmt->execute(['idProjet' => $_GET['id']])) {
        $nbreCat = $stmt->fetch(PDO::FETCH_NUM);
        $stmt = $dbh->prepare('insert into categories (`nom_categories`, `id_projet_projet`,`id_utilisateur_utilisateur`, `ordre`) VALUES (:nomCat, :idProjet, :idUser, :ordre)');
        if (!$stmt->execute(['nomCat' => $newCat, 'idProjet' => $_GET['id'], 'idUser' => $_SESSION['id'], 'ordre' => $nbreCat[0] + 1])) {
            echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
        }
    } else {
        echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
    }
}

if (isset($_POST['supprCat']) && isset($_POST['idCat'])) {
    $stmt = $dbh->prepare('DELETE commentaires FROM commentaires join taches on commentaires.id_taches_taches = taches.id_taches_taches WHERE taches.id_categorie_categories = :idCat');
    if ($stmt->execute(['idCat' => $_POST['idCat']])) {
        $stmt = $dbh->prepare('DELETE fichiers FROM fichiers join taches on fichiers.id_taches_taches = taches.id_taches_taches WHERE taches.id_categorie_categories = :idCat');
        if($stmt->execute(['idCat' => $_POST['idCat']])){
            $stmt = $dbh->prepare('DELETE FROM taches WHERE `id_categorie_categories` = :idCat');
            if ($stmt->execute(['idCat' => $_POST['idCat']])) {
                $stmt = $dbh->prepare('select ordre from categories where `id_categorie_categories` = :idcat');
                if ($stmt->execute(['idcat' => $_POST['idCat']])) {
                    $cats = $stmt->fetchall(PDO::FETCH_NUM)[0][0];
                    $stmt = $dbh->prepare('UPDATE categories set ordre=ordre-1 WHERE ordre > :orderCat;');
                    if ($stmt->execute(['orderCat' => $cats])) {
                        $stmt = $dbh->prepare('DELETE FROM categories WHERE `id_categorie_categories` = :idCat');
                        if (!$stmt->execute(['idCat' => $_POST['idCat']])) {
                            echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
                        }
                    }
                }
            }
        } else {
            echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
        }
    } else {
        echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
    }
}

//! Je vais chercher le projet à cloturer pour passer le statut à terminé

if (isset($_POST['closeProjet']) && isset($_POST['idProjet'])) {
    $stmt = $dbh->prepare('UPDATE projet set terminer_projet=1 WHERE `id_projet_projet` = :idProjet');
    if ($stmt->execute(['idProjet' => $_GET['id']])) {
        header("location:/../../pages/projets.php?page=terminer_projet");
        echo '<span class="mt-3 alert alert-success">Le projet a été cloturé</span>';
    } else {
        echo "<span>Une erreur lors de la mise à jour du kanban a été detectée</span>";
    }
}

if (isset($_POST['suppressionFichier']) && isset($_POST['suppressionIdFichier']) && isset($_POST['suppressionNomFichier'])) {
    $idFichier = htmlentities($_POST['suppressionIdFichier']);
    $stmt = $dbh->prepare('DELETE FROM fichiers WHERE `id_fichier_fichiers` = :idFichier');
    if ($stmt->execute(['idFichier' => $idFichier])) {
        unlink(__DIR__ . '/../../upload/fichiers/' . $_POST['suppressionNomFichier']);
        echo "<span class='m-5 alert-success'>Votre fichier a bien été supprimé </span>";
    }
}
